<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestigationRequest;
use App\Http\Requests\StoreInvestigationRequest;
use App\Models\Complaint;
use App\Models\InvestigationCase;
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
        ])->with(['suspects', 'complaint.attachments', 'evidences'])->firstOrFail();
        return view('cases.show', ['case' => $case]);
        //'complaint.attachments' melalui complaint, ambil complaintattachment karna kan tersambung dengan complaint
        // itu with('berdasarkan nama method di belongsto di model')
    }
    public function store(StoreInvestigationRequest $request, $id)
    { //lock yang akan di urus
        DB::transaction(function () use ($request, $id) {
            $complaint = Complaint::whereKey($id)->lockForUpdate()
                ->findOrFail($id);

            if ($complaint->investigationCase()->exists()) {
                return abort(403, 'complaint sudah menjadi case');
            }
            if ($complaint->status !== 'Pending') {
                abort(403, 'Hanya complaint berstatus Pending yang dapat di jadikan kasus');
            }

            InvestigationCase::create([
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
        });
        return $this->index();
    }
    public function edit($id)
    {
        $case = InvestigationCase::findOrFail($id);
        return view('cases.edit', ['case' => $case]);
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
            if ($data['status'] === 'Closed' && $case->status !== 'Closed') {
                $data['closed_at'] = now();
            }

            if ($data['status'] !== 'Closed') {
                $data['closed_at'] = null;
            }
        }
        $case->update($data);
        return $this->show($id);
    }
}
