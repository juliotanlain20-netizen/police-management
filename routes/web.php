<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintAttachmentController;
use App\Http\Controllers\ComplaintController;
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
    Route::put('/update/{id}', [ComplaintController::class, 'update'])->name('complaint.update');
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
    Route::put('/case/{id}', [InvestigationCaseController::class, 'update'])->name('cases.update');
    Route::get('/case/{id}/edit', [InvestigationCaseController::class, 'edit'])->name('cases.edit');
    //policeOfficerController
    Route::get('/police', [PoliceController::class, 'index'])->middleware('permission:complaint.reject')->name('police.index');
    Route::get('/police/{id}', [PoliceController::class, 'show'])->middleware('permission:complaint.reject')->name('police.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users/police/create', [PoliceController::class, 'create'])->name('police.create');
    Route::post('/police', [PoliceController::class, 'store'])->name('police.store');
    Route::put('/police/{id}', [PoliceController::class, 'update'])->name('police.update');
    Route::get('/police/{id}/edit', [PoliceController::class, 'edit'])->name('police.edit');
});


Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//cek@a pw:12345678=> citizen
//a@a pw:12345678=> police