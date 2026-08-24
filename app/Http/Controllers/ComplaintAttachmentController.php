<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Http\Request;

class ComplaintAttachmentController extends Controller
{
    public function index(Request $request,$id){
        $user =$request->user();
        $isPoliceOrAdmin =$user->roles()->whereIn('roles.name', ['police','admin'])->exists();

        $attachment = ComplaintAttachment::with('complaint')->findOrFail($id);
        if(!$isPoliceOrAdmin && $attachment->complaint->user_id !== $user->id){
            abort(403,'hanya pemilik dan police yang boleh liat');
        }
        return $attachment;
    }

    public function Store(Request $request,$complaintId){
        $complaint= Complaint::findOrFail($complaintId);
        $file =$request->file('attachment');//nanti dari html posting sesuatu
        $path=$file->store('complaint-attachments');//simpan ke complaint-attachment

        $attachment = ComplaintAttachment::create([
            'complaint_id'=>$complaint->id,
            'file_name'=>$file->getClientOriginalName(),
            'file_path'=>$path,
            'mime_type'=>$file->getMimeType(),
            'file_size'=>$file->getSize(),
            'uploaded_at'=>now()
        ]);
        return redirect()->Route('complaint.show',$complaint->id);
    }
}
