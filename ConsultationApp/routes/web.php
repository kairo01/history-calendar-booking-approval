<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/student/consultation/college', [ConsultationController::class, 'showCollegeConsultation'])->name('college.consultation');
Route::get('/student/consultation/highschool', [ConsultationController::class, 'showHSchoolConsultation'])->name('highschool.consultation');
Route::post('/student/consultation/submit', [ConsultationController::class, 'submitConsultation'])->name('consultation.submit');

// Approval routes
Route::get('/dp-head/approval/{id}', [ConsultationController::class, 'dpHeadApproval'])->name('dpHead.approval');
Route::get('/admin-ctation/approval/{id}', [ConsultationController::class, 'adminCtationApproval'])->name('adminCtation.approval');

// Calendar routes
Route::get('/admin/calendar', [ConsultationController::class, 'adminCalendar'])->name('admin.calendar');
Route::get('/dp-head/calendar', [ConsultationController::class, 'dpCalendar'])->name('dp.calendar');
Route::get('/student/calendar', [ConsultationController::class, 'studentCalendar'])->name('student.calendar');

// History routes
Route::get('/admin/history', [ConsultationController::class, 'adminHistory'])->name('admin.history');
Route::get('/dp-head/history', [ConsultationController::class, 'dpHistory'])->name('dp.history');
Route::get('/student/history', [ConsultationController::class, 'studentHistory'])->name('student.history');

Route::post('/consultation/accept/{id}', [ConsultationController::class, 'accept'])->name('consultation.accept');
Route::post('/consultation/decline/{id}', [ConsultationController::class, 'decline'])->name('consultation.decline');


Route::get('/dp-head/approval', [ConsultationController::class, 'dpHeadApproval'])->name('dpHead.approval');
Route::get('/admin-ctation/approval', [ConsultationController::class, 'adminCtationApproval'])->name('adminCtation.approval');

Route::post('/busy-slot', [ConsultationController::class, 'storeBusySlot'])->name('busySlot.store');
