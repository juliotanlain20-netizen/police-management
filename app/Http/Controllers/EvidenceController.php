<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEvidenceRequest;
use App\Models\Evidence;
use App\Models\EvidenceAttachment;
use App\Models\EvidenceCategory;
use App\Models\EvidenceHistory;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidenceController extends Controller
{
    public function index()
    {
        $evidences = Evidence::with('category')->get();
        return view('evidences.index', compact('evidences'));
    }
    public function show($id)
    {
        $evidence = Evidence::with(['category', 'investigationCase', 'attachments'])->findOrFail($id);
        return view('evidences.show', compact('evidence'));
    }
    public function store(Request $request, $caseId)
    {
        $case = InvestigationCase::findOrFail($caseId);
        $request->validate([
            'evidence_category_id' => 'required|exists:evidence_categories,id',
            'evidence_code' => 'required|string|max:50|unique:evidences,evidence_code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'storage_location' => 'required|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        DB::transaction(function () use ($request, $case) {
            $evidence = Evidence::create([
                'investigation_case_id' => $case->id,
                'evidence_category_id' => $request['evidence_category_id'],
                'evidence_code' => $request['evidence_code'],
                'name' => $request['name'],
                'description' => $request['description'],
                'storage_location' => $request['storage_location'],
                'status' => 'Stored',
                'record_status' => 'Valid',
            ]);
            EvidenceHistory::create([
                'evidence_id' => $evidence->id,
                'user_id' => $request->user()->id,
                'activity' => 'Evidence Registered',
                'notes' => 'Evidence pertama kali didaftarkan dengan status Stored.',
            ]);
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('evidence-attachments');

                    EvidenceAttachment::create([
                        'evidence_id' => $evidence->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'uploaded_at' => now()
                    ]);
                }
            }
        });
        return redirect()->route('evidence.index');
    }
    public function edit($id)
    {
        $evidence = Evidence::findOrFail($id);
        $categories = EvidenceCategory::all();
        return view('evidences.edit', compact(['evidence', 'categories']));
    }
    public function update(UpdateEvidenceRequest $request, $id)
    {
        $evidence = Evidence::findOrFail($id);
        if ($evidence->record_status === 'Voided') {
            abort(409, 'Evidence yang sudah voided tidak dapat diubah');
        }

        $data = $request->validated();
        DB::transaction(function () use ($request, $evidence, $data) {
            $oldStatus = $evidence->status;
            $oldLocation = $evidence->storage_location;
            $evidence->update([
                'evidence_category_id' => $data['evidence_category_id'],
                'evidence_code' => $data['evidence_code'],
                'name' => $data['name'],
                'description' => $data['description'],
                'storage_location' => $data['storage_location'],
                'status' => $data['status']
            ]);
            if ($oldStatus !== $data['status']) {
                EvidenceHistory::create([
                    'evidence_id' => $evidence->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Evidence Status Changed',
                    'notes' => $oldStatus . ' → ' . $data['status'],
                ]);
            }

            if ($oldLocation !== $data['storage_location']) {
                EvidenceHistory::create([
                    'evidence_id' => $evidence->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Storage Location Changed',
                    'notes' => $oldLocation . ' → ' . $data['storage_location'],
                ]);
            }
        });
        return redirect()->route('evidence.show', $evidence->id);
    }
    //untuk liat apakah evidence ini valid atau tidak
    public function void(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $id) {

            $evidence = Evidence::findOrFail($id);

            if ($evidence->record_status === 'Voided') {
                abort(409, 'Evidence ini sudah Voided');
            }

            $evidence->update([
                'record_status' => 'Voided',
            ]);

            EvidenceHistory::create([
                'evidence_id' => $evidence->id,
                'user_id' => $request->user()->id,
                'activity' => 'Evidence Voided',
                'notes' => $request['reason'],
            ]);
        });

        return redirect()->route('evidence.index');
    }
}
