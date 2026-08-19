<?php

namespace App\Http\Controllers;

use App\Http\Requests\complaintRequest;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaint = Complaint::all();
        return $complaint;
    }
    public function show($id)
    {
        $complaint = Complaint::where('id', $id)->select([
            'id',
            'category_id',
            'title',
            'description',
            'incident_date',
            'location',
            'status',
            'updated_at'
        ])->with('category')->firstOrFail();
        return $complaint;
        // itu with('berdasarkan nama method di belongsto di model')
    }
    public function store(complaintRequest $request)
    {
        $complaint = Complaint::create([
            'user_id' => 1,
            'category_id' => $request['category_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'incident_date' => $request['incident_date'],
            'location' => $request['location'],
            'status' => 'Pending',
        ]);
        return $complaint;
    }
    public function update(Request $request, $id)
    {
        Complaint::where('id', $id)->update([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'description' => $request['description'],
            'incident_date' => $request['incident_date'],
            'location' => $request['location'],
        ]);
        return $this->show($id);
    }
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'message' => 'complaint sudah jadi kasus dan tidak bisa di hapus'
            ], 409);
        }
        Complaint::destroy($id);
        return $this->index();
    }
    public function requestmoreEvidence($id)
    {
        $complaint = Complaint::findOrFail($id);
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'massage' => 'complaint sudah jadi kasus dan tidak dapat di ubah'
            ], 409);
        }

        $complaint->update([
            'status' => 'Need More Evidence'
        ]);
        return $this->show($id);
    }
    public function reject($id)
    {
        $complaint = Complaint::findOrFail($id);
        if ($complaint->investigationCase()->exists()) {
            return response()->json([
                'massage' => 'complaint sudah jadi kasus dan tidak dapat di ubah'
            ], 409);
        }
        $complaint->update([
            'status' => 'Rejected'
        ]);
        return $this->show($id);
    }
}
