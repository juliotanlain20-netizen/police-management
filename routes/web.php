<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\InvestigationCaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//complaint
Route::get('/complaint',[ComplaintController::class,'index']);
Route::get('/complaint/{id}',[ComplaintController::class,'show']);
Route::post('/complaint',[ComplaintController::class,'store']);
Route::put('/update/{id}',[ComplaintController::class,'update']);
Route::delete('/{id}',[ComplaintController::class,'destroy']);

Route::post('/complaint/{id}/case',[InvestigationCaseController::class,'store']);

//INVESTIGATION CASES
Route::get('/cases',[InvestigationCaseController::class,'index']);
Route::get('/case/{id}',[InvestigationCaseController::class,'show']);
Route::put('/case/{id}',[InvestigationCaseController::class,'update']);
Route::put('moreevidence/{id}',[ComplaintController::class,'requestmoreEvidence']);
Route::put('reject/{id}',[ComplaintController::class,'reject']);