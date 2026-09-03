<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseOfficerController;
use App\Http\Controllers\ComplaintAttachmentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\EvidenceAttachmentController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\InvestigationCaseController;
use App\Http\Controllers\PoliceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {

    //complaint
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint');
    Route::get('/complaint/{id}', [ComplaintController::class, 'show'])->name('complaint.show');
    Route::get('/makecomplaint', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::get('/edit/{id}', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');
    Route::patch('/update/{id}', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::delete('complaint/{id}', [ComplaintController::class, 'destroy'])->name('complaint.destroy');
    Route::patch('/complaints/{id}/request-more-evidence', [ComplaintController::class, 'requestMoreEvidence'])->middleware('permission:complaint.request_more_evidence')->name('complaint.requestMoreEvidence');
    Route::patch('/complaints/{id}/reject', [ComplaintController::class, 'reject'])->middleware('permission:complaint.reject')->name('complaint.reject');
    //ATTACHMENT
    Route::get('/attachment/{id}', [ComplaintAttachmentController::class, 'index']);
    Route::get('/complaint/{complaintId}/attachments/{attachmentId}', [ComplaintAttachmentController::class, 'show'])->name('complaint.attachments.show');
    Route::post('/complaint/{complaintId}/attachments', [ComplaintAttachmentController::class, 'store'])->name('complaint.attachments.store');
    Route::get('/complaint/{complaintId}/attachments/{attachmentId}/download', [ComplaintAttachmentController::class, 'download'])->name('complaint.attachments.download');
    Route::delete('/complaint/{complaintId}/attachments/{attachmentId}', [ComplaintAttachmentController::class, 'destroy'])->name('complaint.attachments.destroy');
    //INVESTIGATION CASES
    Route::post('/complaint/{id}/case', [InvestigationCaseController::class, 'store'])->name('cases.store');
    Route::get('/cases', [InvestigationCaseController::class, 'index'])->name('cases.index');
    Route::get('/case/{id}', [InvestigationCaseController::class, 'show'])->name('cases.show');
    Route::patch('/case/{id}', [InvestigationCaseController::class, 'update'])->name('cases.update');
    Route::get('/case/{id}/edit', [InvestigationCaseController::class, 'edit'])->name('cases.edit');
    //policeOfficerController
    Route::get('/police', [PoliceController::class, 'index'])->middleware('permission:police.view_all')->name('police.index');
    Route::get('/police/{id}', [PoliceController::class, 'show'])->middleware('permission:police.view_all')->name('police.show');
    //Case Officer
    Route::post('/case/{caseId}/store', [CaseOfficerController::class, 'store'])->middleware('permission:case.assign_officer')->name('case.officers.store');
    Route::patch('/case/{caseId}/update/{officerId}', [CaseOfficerController::class, 'update'])->middleware('permission:case.assign_officer')->name('case.officers.update');
    //evidences
    Route::get('/evidences', [EvidenceController::class, 'index'])->name('evidence.index');
    Route::get('/evidences/{id}', [EvidenceController::class, 'show'])->name('evidence.show');
    Route::post('/case/{caseId}/evidence', [EvidenceController::class, 'store'])->name('evidence.store');
    Route::get('/evidences/{id}/edit', [EvidenceController::class, 'edit'])->name('evidence.edit');
    Route::patch('/evidence/{id}', [EvidenceController::class, 'update'])->name('evidence.update');
    Route::patch('/evidence/{id}/void',[EvidenceController::class, 'void'])->name('evidence.void');
    //evidence attahcment
    Route::post('evidence/{evidenceId}/attachment',[EvidenceAttachmentController::class,'store'])->name('evidence.attachment.store');
    Route::get('evidence/{evidenceId}/attachment/{attachmentId}',[EvidenceAttachmentController::class,'show'])->name('evidence.attachment.show');
    Route::get('evidence/{evidenceId}/attachment/{attachmentId}/download',[EvidenceAttachmentController::class,'download'])->name('evidence.attachment.download');
    Route::delete('evidence/{evidenceId}/attachment/{attachmentId}',[EvidenceAttachmentController::class,'destroy'])->name('evidence.attachment.destroy');
    });
//khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users/police/create', [PoliceController::class, 'create'])->name('police.create');
    Route::post('/admin/police', [PoliceController::class, 'store'])->name('police.store');
    Route::put('/admin/police/{id}', [PoliceController::class, 'update'])->name('police.update');
    Route::get('/admin/police/{id}/edit', [PoliceController::class, 'edit'])->name('police.edit');
});


Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//cek@a pw:12345678=> citizen
//a@a pw:12345678=> police