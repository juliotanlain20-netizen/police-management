<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\EvidenceAttachment;
use App\Models\EvidenceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvidenceAttachmentController extends Controller
{
    public function store(Request $request, $evidenceId)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        $evidence = Evidence::with('investigationCase')->findOrFail($evidenceId);

        $this->ensureAssignedToCase(
            $request->user(),
            $evidence->investigationCase
        );
        $file = $request->file('attachment');
        if ($evidence->record_status !== 'Valid') {
            abort(409, 'Evidence yang sudah Voided tidak dapat diubah');
        }

        DB::transaction(function () use ($request, $evidence, $file) {
            EvidenceAttachment::create([
                'evidence_id' => $evidence->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $file->store('evidence-attachments'),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_at' => now(),
            ]);
            EvidenceHistory::create([
                'evidence_id' => $evidence->id,
                'user_id' => $request->user()->id,
                'activity' => 'Evidence Attachment Added',
                'notes' => 'Attachment ditambahkan: ' . $file->getClientOriginalName()
            ]);
        });
        return redirect()->route('evidence.edit', $evidence->id)
            ->with('success', 'Attachment berhasil ditambahkan');
    }
    public function show($evidenceId, $attachmentId)
    {
        $evidence = Evidence::findOrFail($evidenceId);
        $attachment = EvidenceAttachment::where('evidence_id', $evidence->id)
            ->findOrFail($attachmentId);
        if (!Storage::exists($attachment->file_path)) {
            abort(404, 'File attachment tidak ditemukan di storage');
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
    public function download($evidenceId, $attachmentId)
    {
        $evidence = Evidence::findOrFail($evidenceId);
        $attachment = EvidenceAttachment::where('evidence_id', $evidence->id)
            ->findOrFail($attachmentId);
        if (!Storage::exists($attachment->file_path)) {
            abort(404, 'File attachment tidak ditemukan di storage');
        }
        return Storage::download(
            $attachment->file_path,
            $attachment->file_name,
        );
    }
    public function destroy(Request $request, $evidenceId, $attachmentId)
    {
        $evidence = Evidence::with('investigationCase')->findOrFail($evidenceId);

        $this->ensureAssignedToCase(
            $request->user(),
            $evidence->investigationCase
        );
        if ($evidence->record_status !== 'Valid') {
            abort(409, 'Evidence yang sudah Voided tidak dapat diubah');
        }
        $attachment = EvidenceAttachment::where('evidence_id', $evidence->id)
            ->findOrFail($attachmentId);
        DB::transaction(function () use ($attachment, $evidence, $request) {
            $fileName = $attachment->file_name;
            if (Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
            }
            $attachment->delete();
            EvidenceHistory::create([
                'evidence_id' => $evidence->id,
                'user_id' => $request->user()->id,
                'activity' => 'Evidence Attachment Removed',
                'notes' => 'Attachment dihapus: ' . $fileName
            ]);
        });
        return redirect()->route('evidence.edit', $evidence->id)
            ->with('success', 'Attachment berhasil dihapus');
    }
}
