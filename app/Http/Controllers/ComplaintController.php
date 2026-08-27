<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $isPoliceOrAdmin = $user->roles()
            ->whereIn('roles.name', ['police', 'admin'])
            ->exists();

        $query = Complaint::with('category');

        if (!$isPoliceOrAdmin) {
            // Citizen / Author hanya miliknya
            $query->where('user_id', $user->id);
        } else {
            if ($request->scope === 'mine') {
                // Police / Admin sedang melihat complaint sendiri
                $query->where('user_id', $user->id);
            } else {
                // Semua complaint kecuali Draft orang lain
                $query->where(function ($q) use ($user) {
                    $q->where('status', '!=', 'Draft')
                        ->orWhere('user_id', $user->id);
                });
            }
        }

        $complaints = $query->get();
        return view('complaint.index', compact('complaints'));
    }
    public function show(Request $request, $id)
    {
        $complaint = Complaint::where('id', $id)
            ->with(['category', 'attachments'])->firstOrFail();
        $user = $request->user(); //sedang login
        $isPoliceOrAdmin = $user->roles()->whereIn('name', ['police', 'admin'])
            ->exists();
        // Draft selalu private
        if (
            $complaint->status === 'Draft' &&
            $complaint->user_id !== $user->id
        ) {
            abort(403, 'Draft hanya dapat dilihat oleh pemilik');
        }
        // Non police/admin hanya boleh melihat miliknya sendiri
        if (
            !$isPoliceOrAdmin &&
            $complaint->user_id !== $user->id
        ) {
            abort(403, 'Kamu tidak memiliki akses ke complaint ini');
        }
        return view('complaint.show', [
            'complaint' => $complaint,
        ]);
        // return view('complaint.show', compact('complaint'));
        // return view('complaint.show', $complaint);
        // $complaint = Complaint::where('id', $id)->select([
        //     'id',
        //     'category_id',
        //     'title',
        //     'description',
        //     'incident_date',
        //     'location',
        //     'status',
        //     'updated_at'
        // ])->with('category')->firstOrFail();
        // return $complaint;
        // itu with('berdasarkan nama method di belongsto di model')
    }
    public function create()
    {
        $categories = ComplaintCategory::all();
        return view('complaint.create', compact('categories'));
    }

    public function store(ComplaintRequest $request)
    {
        if ($request->action === 'submit') {
            $status = 'Pending';
        } else {
            $status = 'Draft';
        }

        $complaint = Complaint::create([
            'user_id' => $request->user()->id,
            'category_id' => $request['category_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'incident_date' => $request['incident_date'],
            'location' => $request['location'],
            'status' => $status,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaint-attachments');

                $attachment = ComplaintAttachment::create([
                    'complaint_id' => $complaint->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'uploaded_at' => now()
                ]);
            }
        }
        return redirect()->route('complaint');
    }
    public function edit(Request $request, $id)
    {
        $complaint = Complaint::findOrfail($id);
        $categories = ComplaintCategory::all();
        if ($complaint->user_id !== $request->user()->id) {
            abort(403, 'gak boleh liat complaint orang lain');
        }
        if (!in_array($complaint->status, ['Draft', 'Need More Evidence'])) {
            abort(403, 'Complaint dengan status ini tidak dapat diedit');
        }
        return view('complaint.edit', ['complaint' => $complaint, 'categories' => $categories]);
    }
    //BELUM SELESAI
    public function update(ComplaintRequest $request, $id)
    {
        $complaint = Complaint::findOrfail($id);
        //user_id di complaint sesuai yang di cari di atas
        //samakan dengan di sesession
        if ($complaint->user_id !== $request->user()->id) {
            abort(403, 'gak boleh liat complaint orang lain');
        }
        //mengechek status fraft, atau need more evidence, kalau iya negasi jadi false
        //jadinya gak ke eksekusi
        if (!in_array($complaint->status, ['Draft', 'Need More Evidence'])) {
            abort(403, 'Complaint dengan status ini tidak dapat diedit');
        }

        $complaint->update([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'description' => $request['description'],
            'incident_date' => $request['incident_date'],
            'location' => $request['location'],
        ]);
        if ($request->action === 'submit') {
            $complaint->update([
                'status' => 'Pending'
            ]);
        }
        return redirect()->route('complaint.show', $complaint->id);
    }
    public function destroy(Request $request, $id)
    {
        $user = $request->User();
        $complaint = Complaint::findOrFail($id);
        if ($complaint->user_id !== $user->id) {
            abort(403, 'hanya pemilik yang boleh hapus complaint sendiri');
        }
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'message' => 'complaint sudah jadi kasus dan tidak bisa di hapus'
            ], 409);
        }
        foreach ($complaint->attachments as $attachment) {
            Storage::delete($attachment->file_path);
        }
        $complaint->delete();
        return redirect()->route('complaint');
    }
    public function requestMoreEvidence(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $user = $request->User();
        $isPoliceandAdmin = $user->roles()->whereIn('roles.name', ['police', 'admin'])->exists();
        if (!$isPoliceandAdmin) {
            abort(403, 'hanya polisi dan admin yang boleh ubah ke status ini');
        }
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'message' => 'complaint sudah jadi kasus dan tidak dapat di ubah'
            ], 409);
        }
        if ($complaint->status !== 'Pending') {
            abort(403, 'hanya boleh merubah yang berstatus pending');
        }

        $complaint->update([
            'status' => 'Need More Evidence'
        ]);
        return redirect()->route('complaint.show', $complaint->id);
    }
    public function reject(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $user = $request->User();
        $isPoliceandAdmin = $user->roles()->whereIn('roles.name', ['police', 'admin'])->exists();
        if (!$isPoliceandAdmin) {
            abort(403, 'hanya polisi dan admin yang boleh ubah ke status ini');
        }
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'message' => 'complaint sudah jadi kasus dan tidak dapat di ubah'
            ], 409);
        }
        if ($complaint->status !== 'Pending') {
            abort(403, 'hanya boleh merubah yang berstatus pending');
        }
        $complaint->update([
            'status' => 'Rejected'
        ]);
        return redirect()->route('complaint.show', $complaint->id);
    }
    //untuk status need more evidence dan draft
}
// $request->user()->id
//INTINYA UNTUK MENGECHEK SESSION