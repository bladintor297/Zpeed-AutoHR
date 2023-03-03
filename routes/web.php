<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Resources Routes
Route::resource('staff', '\App\Http\Controllers\StaffController')->middleware('role:1');;
Route::resource('claim', '\App\Http\Controllers\ClaimController');
Route::resource('payment', '\App\Http\Controllers\PaymentController')->middleware('role:1');;
Route::resource('milleage', '\App\Http\Controllers\MilleageController');
Route::resource('leave', '\App\Http\Controllers\LeaveController');
Route::resource('project', '\App\Http\Controllers\ProjectController')->middleware('role:1');;
Route::resource('profile', '\App\Http\Controllers\ProfileController');
Route::resource('certificate', '\App\Http\Controllers\CertificateController');

//Claim Routes
Route::get('claim-status', '\App\Http\Controllers\ClaimController@status');
Route::get('claim-list', '\App\Http\Controllers\ClaimController@list')->middleware('role:1');;
Route::get('/milleage/delete/{id}', [App\Http\Controllers\MilleageController::class, 'destroy'])->name('milleage.destroy');
Route::get('/claim/delete/{id}', [App\Http\Controllers\ClaimController::class, 'destroy'])->name('claim.destroy');
Route::get('/cancelClaim/{id}', [App\Http\Controllers\ClaimController::class, 'deleteCl'])->name('claim.delete');
Route::get('/claim/edit/{id}', [App\Http\Controllers\ClaimController::class, 'edit'])->name('claim.edit');
Route::get('/approveCl/{id}', [ClaimController::class, 'approveCl'])->name('claim.approve')->middleware('role:1');;
Route::get('/rejectCl/{id}', [ClaimController::class, 'rejectCl'])->name('claim.reject')->middleware('role:1');;
Route::get('/generateClaim/{id}', [ClaimController::class, 'generatePDF'])->name('claim.generatePDF');

//Leave Routes
Route::get('leave-status', '\App\Http\Controllers\LeaveController@status');
Route::get('leave-list', '\App\Http\Controllers\LeaveController@list');
Route::get('/leave/edit/{id}', [App\Http\Controllers\LeaveController::class, 'edit'])->name('leave.edit');
Route::get('lvreport-list', '\App\Http\Controllers\LeaveController@report');
Route::get('/approveLv/{id}', [LeaveController::class, 'approveLv'])->name('leave.approve');
Route::get('/rejectLv/{id}', [LeaveController::class, 'rejectLv'])->name('leave.reject');
Route::get('/generateLeave/{id}', [LeaveController::class, 'generatePDF'])->name('leave.generatePDF');
Route::get('/cancelLeave/{id}', [App\Http\Controllers\LeaveController::class, 'destroy'])->name('leave.delete');

//Staff Routes
Route::get('approve-list', '\App\Http\Controllers\StaffController@approve');
Route::get('staff-list', '\App\Http\Controllers\StaffController@list');
Route::get('/generatePDF', [StaffController::class, 'generatePDF'])->name('staff.generatePDF');

//Project Routes
Route::get('deleteProject/{id}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('project.destroy');
Route::get('project-list', '\App\Http\Controllers\ProjectController@list');
Route::get('pjreport-list', '\App\Http\Controllers\ProjectController@report');

//Profile Routes
Route::get('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('update-password');
Route::get('/certificate/delete/{id}', [App\Http\Controllers\CertificateController::class, 'destroy'])->name('certificate.destroy');
Route::get('/generate-cv/{id}', [App\Http\Controllers\ProfileController::class, 'generatePDF'])->name('generate-cv');

Route::get('send-email', [SendEmailController::class, 'index']);
