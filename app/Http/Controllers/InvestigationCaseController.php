<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestigationRequest;
use App\Http\Requests\StoreInvestigationRequest;
use App\Models\CaseHistory;
use App\Models\Complaint;
use App\Models\EvidenceCategory;
use App\Models\InvestigationCase;
use App\Models\PoliceOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestigationCaseController extends Controller
{
    public function index()
    {
        $cases = InvestigationCase::all();
        return view('cases.index', compact('cases'));
    }
    public function show($id)
    {
        $police = PoliceOfficer::where('status', 'Active')->with('user')->get();
        $evidenceCategories = EvidenceCategory::all();
        // return 'masuk controller, id = ' . $id;
        $case = InvestigationCase::where('id', $id)->select([
            'id',
            'complaint_id',
            'case_number',
            'title',
            'description',
            'status',
            'priority',
            'opened_at',
            'closed_at',
        ])->with(['suspects', 'complaint.attachments', 'evidences.category', 'officers.user', 'histories.user'])->firstOrFail();
        return view('cases.show', compact('case', 'police', 'evidenceCategories'));
        //'complaint.attachments' melalui complaint, ambil complaintattachment karna kan tersambung dengan complaint
        // itu with('berdasarkan nama method di belongsto di model')
    }
    public function store(StoreInvestigationRequest $request, $id)
    { //lock yang akan di urus
        $data = $request->validated();
        DB::transaction(function () use ($request, $data, $id) {
            $complaint = Complaint::whereKey($id)->lockForUpdate()
                ->firstOrFail();

            if ($complaint->investigationCase()->exists()) {
                abort(409, 'complaint sudah menjadi case');
            }
            if ($complaint->status !== 'Pending') {
                abort(403, 'Hanya complaint berstatus Pending yang dapat di jadikan kasus');
            }

            $case = InvestigationCase::create([
                'complaint_id' => $complaint->id,
                'case_number' => $data['case_number'],
                'title' => $complaint->title,
                'description' => $complaint->description,
                'status' => 'Open',
                'priority' => $data['priority'],
                'opened_at' => now()
            ]);
            $complaint->update([
                'status' => 'Approved'
            ]);
            CaseHistory::create([
                'investigation_case_id' => $case->id,
                'user_id' => $request->user()->id,
                'activity' => 'Case Created',
                'notes' => 'Investigation case dibuat dari complaint.',
            ]);
        });
        return redirect()->route('cases.index')->with('success', 'Berhasil menambah case');
    }
    private function ensureAssignedOfficer($user, InvestigationCase $case)
    {
        $officer = $user->officer;
        $isAdmin = $user->roles()
            ->where('roles.name', 'admin')
            ->exists();
        if ($isAdmin) {
            return;
        }

        if (!$officer) {
            abort(403, 'User bukan Police Officer');
        }
        if ($officer->status !== 'Active') {
            abort(403, 'Police Officer sudah tidak aktif');
        }

        $assigned = $case->officers()
            ->where('police_officers.id', $officer->id)
            ->wherePivot('status', 'Active')
            ->exists();

        if (!$assigned) {
            abort(403, 'Hanya officer yang ditugaskan pada case ini yang dapat mengubah case');
        }
    }
    public function edit(Request $request, $id)
    {

        $case = InvestigationCase::findOrFail($id);
        $this->ensureAssignedOfficer(
            $request->user(),
            $case
        );
        return view('cases.edit', ['case' => $case]);
    }
    public function update(InvestigationRequest $request, $id)
    {
        $case = InvestigationCase::findOrFail($id);
        $data = $request->validated();
        $this->ensureAssignedOfficer(
            $request->user(),
            $case
        );

        DB::transaction(function () use ($request, $case, $data) {

            $oldStatus = $case->status;
            $closedAt = $case->closed_at;
            if ($data['status'] === 'Closed' && $oldStatus !== 'Closed') {
                $closedAt = now();
            }
            if ($data['status'] !== 'Closed') {
                $closedAt = null;
            }
            $case->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'closed_at' => $closedAt,
            ]);
            if ($oldStatus !== $data['status']) {
                CaseHistory::create([
                    'investigation_case_id' => $case->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Case Status Changed',
                    'notes' => $oldStatus . ' → ' . $data['status'],
                ]);
            }
        });

        return redirect()
            ->route('cases.show', $case->id)
            ->with('success', 'Investigation case berhasil diperbarui.');
    }
}
