<?php

namespace App\Http\Controllers;

use App\Models\CaseHistory;
use App\Models\InvestigationCase;
use App\Models\PoliceOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseOfficerController extends Controller
{
    public function store(Request $request, $caseId)
    {
        $request->validate([
            'police_officer_id' => 'required|exists:police_officers,id',
        ]);
        $case = InvestigationCase::findOrFail($caseId);
        $police = PoliceOfficer::with('user')->findOrFail($request['police_officer_id']);
        DB::transaction(function () use ($request, $case, $police) {
            if ($police->status !== 'Active') {
                abort(403, 'hanya boleh police yang active');
            }
            if ($case->officers()->wherePivot('police_officer_id', $police->id)->wherePivot('status', 'Active')->exists()) {
                abort(409, 'Police ini sudah aktif pada case ini');
            }
            if ($case->officers()->wherePivot('police_officer_id', $police->id)->wherePivot('status', 'Inactive')->exists()) {
                $case->officers()->updateExistingPivot($police->id, [
                    'status' => 'Active',
                    'assigned_at' => now()
                ]);
                CaseHistory::create([
                    'investigation_case_id' => $case->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Officer Reactivated',
                    'notes' => 'Officer ' . $police->user->name . ' kembali ditugaskan ke kasus.',
                ]);
                return;
            }
            $case->officers()->attach($police->id, [
                'status' => 'Active',
                'assigned_at' => now(),
            ]);
            CaseHistory::create([
                'investigation_case_id' => $case->id,
                'user_id' => $request->user()->id,
                'activity' => 'Officer Assigned',
                'notes' => 'Officer ' . $police->user->name . ' ditugaskan ke kasus.',
            ]);
        });
        return redirect()
            ->route('cases.show', $caseId)
            ->with('success', 'Officer berhasil ditugaskan.');
    }
    public function update(Request $request, $caseId, $officerId)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        $case = InvestigationCase::findOrFail($caseId);

        $officer = $case->officers()
            ->wherePivot('police_officer_id', $officerId)
            ->with('user')
            ->first();

        if (!$officer) {
            abort(404, 'Assignment tidak ditemukan');
        }
        if ($officer->status !== 'Active') {
            abort(403, 'Police Officer sudah tidak aktif');
        }

        $oldStatus = $officer->pivot->status;
        $newStatus = $request['status'];

        if ($oldStatus === $newStatus) {
            return redirect()->route('cases.show', $caseId);
        }

        if ($newStatus === 'Active' && $officer->status !== 'Active') {
            abort(403, 'Hanya police yang Active yang dapat ditugaskan');
        }

        DB::transaction(function () use (
            $request,
            $case,
            $officer,
            $officerId,
            $oldStatus,
            $newStatus
        ) {

            $data = [
                'status' => $newStatus,
            ];

            if ($newStatus === 'Active') {
                $data['assigned_at'] = now();
            }

            $case->officers()->updateExistingPivot(
                $officerId,
                $data
            );

            if ($oldStatus === 'Inactive' && $newStatus === 'Active') {
                CaseHistory::create([
                    'investigation_case_id' => $case->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Officer Reactivated',
                    'notes' => 'Officer ' . $officer->user->name .
                        ' kembali ditugaskan ke kasus.',
                ]);
            }

            if ($oldStatus === 'Active' && $newStatus === 'Inactive') {
                CaseHistory::create([
                    'investigation_case_id' => $case->id,
                    'user_id' => $request->user()->id,
                    'activity' => 'Officer Assignment Inactivated',
                    'notes' => 'Officer ' . $officer->user->name .
                        ' dinonaktifkan dari penugasan kasus.',
                ]);
            }
        });

        return redirect()
            ->route('cases.show', $caseId)
            ->with('success', 'Status assignment berhasil diperbarui.');
    }
}
