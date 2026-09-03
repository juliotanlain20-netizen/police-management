<?php

namespace App\Http\Controllers;

use App\Models\InvestigationCase;
use App\Models\PoliceOfficer;
use Illuminate\Http\Request;

class CaseOfficerController extends Controller
{
    public function store(Request $request, $caseId)
    {
        $request->validate([
            'police_officer_id' => 'required|exists:police_officers,id',
        ]);
        $case = InvestigationCase::findOrFail($caseId);
        $police = PoliceOfficer::findOrFail($request['police_officer_id']);
        if ($police->status !== 'Active') {
            abort(403, 'hanya boleh police yang active');
        }
        if ($case->officers()->where('police_officer_id', $police->id)->wherePivot('status', 'Active')->exists()) {
            abort(409, 'Police ini sudah aktif pada case ini');
        }
        if ($case->officers()->where('police_officer_id', $police->id)->wherePivot('status', 'Inactive')->exists()) {
            $case->officers()->updateExistingPivot($police->id, [
                'status' => 'Active',
                'assigned_at' => now()
            ]);
            return 'assignment diaktifkan kembali';
        }
        $case->officers()->attach($police->id, [
            'status' => 'Active',
            'assigned_at' => now(),
        ]);
        return 'bisa kok';
    }
    public function update(Request $request, $caseId, $officerId)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);
        $case = InvestigationCase::findOrFail($caseId);
        if (!$case->officers()->wherePivot('police_officer_id', $officerId)->exists()) {
            abort(404, 'gak ada assigment ini');
        }
        $data=[
            'status'=>$request['status']
        ];
        if ($request['status'] === 'Active') {
            $police = PoliceOfficer::findOrFail($officerId);
            if ($police->status !== 'Active') {
                abort(403, 'hanya boleh police yang active');
            }
            $data['assigned_at'] = now();
        }
        $case->officers()->updateExistingPivot($officerId,$data);
        return redirect()->route('cases.show',$caseId);
    }
}
