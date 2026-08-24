<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestigationRequest;
use App\Http\Requests\StoreInvestigationRequest;
use App\Models\Complaint;
use App\Models\InvestigationCase;
use Illuminate\Http\Request;

class InvestigationCaseController extends Controller
{
    public function index()
    {
        $cases = InvestigationCase::all();
        return $cases;
    }
    public function show($id)
    {
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
        ])->with(['suspects', 'complaint.attachments','evidences'])->firstOrFail();
        return $case;
        //'complaint.attachments' melalui complaint, ambil complaintattachment karna kan tersambung dengan complaint
        // itu with('berdasarkan nama method di belongsto di model')
    }
    public function store(StoreInvestigationRequest $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        if($complaint->investigationCase()->exists()){
            return response()->json([
                'message'=>'complaint sudah menjadi case'
            ],409);
        }
        $case = InvestigationCase::create([
            'complaint_id' => $complaint->id,
            'case_number' => $request['case_number'],
            'title' => $complaint->title,
            'description' => $complaint->description,
            'status' => 'Open',
            'priority' => $request['priority'],
            'opened_at' => now()
        ]);
        $complaint->update([
            'status' => 'Approved'
        ]);
        return $this->index();
    }
    public function update(InvestigationRequest $request, $id)
    {
        // InvestigationCase::where('id',$id)->update([
        //     'case_number'=>$request['case_number'],
        //     'title'=>$request['title'],
        //     'description'=>$request['description'],
        //     'status'=>$request['status'],
        //     'priority'=>$request['priority'],
        //     'closed_at'=>$request['status'] === 'Closed' ? now() : null,
        // ]);
        //AGAR KALAU DI UPDATE SESUAI KEINGINAN SAJA
        $case = InvestigationCase::findOrFail($id);
        $data = $request->validated();

        if (isset($data['status'])) {
            $data['closed_at'] = $data['status'] === 'Closed'? now() : null;
        }
        $case->update($data);
        return $this->show($id);
    }
}
