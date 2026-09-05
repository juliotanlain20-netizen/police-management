<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseOfficerController;
use App\Http\Controllers\ComplaintAttachmentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\EvidenceAttachmentController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\InvestigationCaseController;
use App\Http\Controllers\PoliceController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SuspectController;
use App\Http\Controllers\UserRoleController;

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
    Route::patch('/complaints/{id}/request-more-evidence', [ComplaintController::class, 'requestMoreEvidence'])->middleware(['permission:complaint.request_more_evidence', 'active.police'])->name('complaint.requestMoreEvidence');
    Route::patch('/complaints/{id}/reject', [ComplaintController::class, 'reject'])->middleware(['permission:complaint.reject', 'active.police'])->name('complaint.reject');
    //ATTACHMENT
    Route::get('/complaint/{complaintId}/attachments/{attachmentId}', [ComplaintAttachmentController::class, 'show'])->name('complaint.attachments.show');
    Route::post('/complaint/{complaintId}/attachments', [ComplaintAttachmentController::class, 'store'])->name('complaint.attachments.store');
    Route::get('/complaint/{complaintId}/attachments/{attachmentId}/download', [ComplaintAttachmentController::class, 'download'])->name('complaint.attachments.download');
    Route::delete('/complaint/{complaintId}/attachments/{attachmentId}', [ComplaintAttachmentController::class, 'destroy'])->name('complaint.attachments.destroy');
    //INVESTIGATION CASES
    Route::post('/complaint/{id}/case', [InvestigationCaseController::class, 'store'])->middleware(['permission:case.create','active.police'])->name('cases.store');
    Route::get('/cases', [InvestigationCaseController::class, 'index'])->middleware('permission:case.view_all')->name('cases.index');
    Route::get('/case/{id}', [InvestigationCaseController::class, 'show'])->middleware('permission:case.view_all')->name('cases.show');
    Route::patch('/case/{id}', [InvestigationCaseController::class, 'update'])->middleware(['permission:case.update', 'active.police'])->name('cases.update');
    Route::get('/case/{id}/edit', [InvestigationCaseController::class, 'edit'])->middleware(['permission:case.update', 'active.police'])->name('cases.edit');
    //policeOfficerController
    Route::get('/police', [PoliceController::class, 'index'])->middleware('permission:police.view_all')->name('police.index');
    Route::get('/police/{id}', [PoliceController::class, 'show'])->middleware('permission:police.view_all')->name('police.show');
    //Case Officer
    Route::post('/case/{caseId}/officers', [CaseOfficerController::class, 'store'])->middleware(['permission:case.assign_officer', 'active.police'])->name('case.officers.store');
    Route::patch('/case/{caseId}/officers/{officerId}', [CaseOfficerController::class, 'update'])->middleware(['permission:case.assign_officer', 'active.police'])->name('case.officers.update');
    //evidences
    Route::get('/evidences', [EvidenceController::class, 'index'])->middleware('permission:evidence.view')->name('evidence.index');
    Route::get('/evidences/{id}', [EvidenceController::class, 'show'])->middleware('permission:evidence.view')->name('evidence.show');
    Route::post('/case/{caseId}/evidence', [EvidenceController::class, 'store'])->middleware(['permission:evidence.create', 'active.police'])->name('evidence.store');
    Route::get('/evidences/{id}/edit', [EvidenceController::class, 'edit'])->middleware(['permission:evidence.update', 'active.police'])->name('evidence.edit');
    Route::patch('/evidence/{id}', [EvidenceController::class, 'update'])->middleware(['permission:evidence.update', 'active.police'])->name('evidence.update');
    Route::patch('/evidence/{id}/void', [EvidenceController::class, 'void'])->middleware(['permission:evidence.void', 'active.police'])->name('evidence.void');
    //evidence attahcment
    Route::post('evidence/{evidenceId}/attachment', [EvidenceAttachmentController::class, 'store'])->middleware(['permission:evidence.manage_attachment', 'active.police'])->name('evidence.attachment.store');
    Route::get('evidence/{evidenceId}/attachment/{attachmentId}', [EvidenceAttachmentController::class, 'show'])->middleware('permission:evidence.view')->name('evidence.attachment.show');
    Route::get('evidence/{evidenceId}/attachment/{attachmentId}/download', [EvidenceAttachmentController::class, 'download'])->middleware('permission:evidence.view')->name('evidence.attachment.download');
    Route::delete('evidence/{evidenceId}/attachment/{attachmentId}', [EvidenceAttachmentController::class, 'destroy'])->middleware(['permission:evidence.manage_attachment', 'active.police'])->name('evidence.attachment.destroy');
    //suspect
    Route::get('suspect/{id}', [SuspectController::class, 'show'])->middleware('permission:suspect.view')->name('suspect.show');
    Route::post('case/{caseId}/suspect', [SuspectController::class, 'store'])->middleware(['permission:suspect.create','active.police'])->name('suspect.store');
    Route::patch('suspect/{id}', [SuspectController::class, 'update'])->middleware(['permission:suspect.update', 'active.police'])->name('suspect.update');
    Route::get('suspect/{id}/edit', [SuspectController::class, 'edit'])->middleware(['permission:suspect.update', 'active.police'])->name('suspect.edit');
    //logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
//khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    //userRoleController
    Route::get('roles', [UserRoleController::class, 'index'])->name('user-role.index');
    Route::get('roles/{userId}/edit', [UserRoleController::class, 'edit'])->name('user-role.edit');
    Route::patch('roles/{userId}/edit', [UserRoleController::class, 'update'])->name('user-role.update');
    //RolePermissionController
    Route::get('permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::get('permission/{roleId}/edit', [RolePermissionController::class, 'edit'])->name('role-permission.edit');
    Route::patch('permission/{roleId}/edit', [RolePermissionController::class, 'update'])->name('role-permission.update');
    //police controller
    Route::get('/admin/users/police/create', [PoliceController::class, 'create'])->name('police.create');
    Route::post('/admin/police', [PoliceController::class, 'store'])->name('police.store');
    Route::patch('/admin/police/{id}', [PoliceController::class, 'update'])->name('police.update');
    Route::get('/admin/police/{id}/edit', [PoliceController::class, 'edit'])->name('police.edit');
});
//untuk police
// Route::get('/register/police', [AuthController::class, 'showPoliceRegisterForm'])->name('police.register.form');
// Route::post('/register/police', [AuthController::class, 'registerPolice'])->name('police.register');
//admin
// Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->middleware(['auth', 'admin']);
//umum
Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
});
