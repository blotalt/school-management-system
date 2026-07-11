<?php

use App\Http\Controllers\Student\EnrollmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Student\EnrollmentController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:teacher'])->get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

Route::middleware(['auth', 'role:student'])->get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('students', StudentController::class)->except('show');
    Route::resource('teachers', TeacherController::class)->except('show');
    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);
});





