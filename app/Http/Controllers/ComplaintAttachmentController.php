<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintAttachmentController extends Controller
{


    public function Store(Request $request, $complaintId)
    {
        $complaint = Complaint::findOrFail($complaintId);
        if ($complaint->user_id !== $request->user()->id) {
            abort(403, 'hanya pemilik yang boleh tambah attachment ');
        }
        if (!in_array($complaint->status, ['Draft', 'Need More Evidence'])) {
            abort(403, 'complaint ini sudah tidak bisa ditambahkan attachment');
        }
        $request->validate([
            'attachment' => 'required|file|max:10240',
        ]);
        $file = $request->file('attachment'); //nanti dari html posting sesuatu
        $path = $file->store('complaint-attachments'); //simpan ke complaint-attachment

        $attachment = ComplaintAttachment::create([
            'complaint_id' => $complaint->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_at' => now()
        ]);
        return redirect()->Route('complaint.show', $complaint->id);
    }
    public function show(Request $request, $complaintId, $attachmentId)
    {
        $complaint = Complaint::findOrFail($complaintId);

        $attachment = ComplaintAttachment::where(
            'complaint_id',
            $complaint->id
        )->findOrFail($attachmentId);

        $user = $request->user();
        $isPoliceOrAdmin = $user->roles()
            ->whereIn('roles.name', ['police', 'admin'])
            ->exists();
        if ($complaint->status === 'Draft' && $complaint->user_id !== $user->id) {
            abort(403);
        }
        if (!$isPoliceOrAdmin && $complaint->user_id !== $user->id) {
            abort(403);
        }
        if (!Storage::exists($attachment->file_path)) {
            return response('File attachment tidak ditemukan di storage', 404);
        }
        return Storage::response(
            $attachment->file_path,
            $attachment->file_name,
            [
                'Content-Type' => $attachment->mime_type
            ],
            'inline'
        );
    }
    public function download(Request $request, $complaintId, $attachmentId)
    {
        $complaint = Complaint::findOrFail($complaintId);
        $attachment = ComplaintAttachment::where('complaint_id', $complaint->id)->findOrFail($attachmentId);
        $user = $request->user();

        $isPoliceOrAdmin = $user->roles()
            ->whereIn('roles.name', ['police', 'admin'])
            ->exists();
        if ($complaint->status === 'Draft' && $complaint->user_id !== $user->id) {
            abort(403);
        }
        if (!$isPoliceOrAdmin && $complaint->user_id !== $user->id) {
            abort(403);
        }
        if (!Storage::exists($attachment->file_path)) {
            return response('File attachment tidak ditemukan di storage', 404);
        }
        return Storage::download(
            $attachment->file_path,
            $attachment->file_name
        );
    }
    public function destroy(Request $request, $complaintId, $attachmentId)
    {
        $complaint = Complaint::findOrFail($complaintId);
        $attachment = ComplaintAttachment::where('complaint_id', $complaint->id)->findOrFail($attachmentId);
        $user = $request->user();
        if ($complaint->user_id !== $user->id) {
            abort(403, 'Hanya pemilik complaint yang boleh menghapus attachment');
        }
        if (!in_array($complaint->status, ['Draft', 'Need More Evidence'])) {
            abort(403, 'Attachment complaint ini sudah tidak dapat dihapus');
        }
        if (Storage::exists($attachment->file_path)) {
            Storage::delete($attachment->file_path);
        }

        $attachment->delete();
        return redirect()
            ->route('complaint.edit', $complaint->id)
            ->with('success', 'Attachment berhasil dihapus');
    }
}
