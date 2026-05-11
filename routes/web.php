<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('auth.attempt');
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/user', [AdminController::class, 'users'])->name('admin.users');
Route::post('/admin/user', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::get('/admin/students', [AdminController::class, 'students']);
Route::get('/admin/faculity', [AdminController::class, 'faculty']);
Route::get('/admin/faculty', [AdminController::class, 'faculty']);
Route::get('/admin/courses', [AdminController::class, 'courses'])->name('admin.courses');
Route::get('/admin/courses/new', [AdminController::class, 'newCourse'])->name('admin.courses.newCourse');
Route::post('/admin/courses/new', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments');
Route::get('/admin/departments/{department}', [AdminController::class, 'department'])->name('admin.departments.show');
Route::get('/admin/departments/{department}/manage', [AdminController::class, 'manageDepartment'])->name('admin.departments.manage');
Route::get('/admin/departments/{department}/courses/new', [AdminController::class, 'newDepartmentCourse'])->name('admin.departments.courses.new');
Route::post('/admin/departments/{department}/courses/new', [AdminController::class, 'storeDepartmentCourse'])->name('admin.departments.courses.store');
Route::get('/admin/departments/{department}/courses/{course}/edit', [AdminController::class, 'editDepartmentCourse'])->name('admin.departments.courses.edit');
Route::put('/admin/departments/{department}/courses/{course}', [AdminController::class, 'updateDepartmentCourse'])->name('admin.departments.courses.update');
Route::delete('/admin/departments/{department}/courses/{course}', [AdminController::class, 'destroyDepartmentCourse'])->name('admin.departments.courses.destroy');

Route::get('/admin/reports', [AdminController::class, 'reports']);

Route::get('/faculty/dashboard', [FacultyController::class, 'dashboard']);
Route::get('/faculty/feedback', [FacultyController::class, 'feedback']);
Route::get('/faculty/analytics', [FacultyController::class, 'analytics']);
Route::get('/faculty/profile', [FacultyController::class, 'profile']);

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
Route::get('/student/courses', [StudentController::class, 'courses']);
Route::get('/student/feedback', [StudentController::class, 'feedback']);
Route::get('/student/feedback/history', [StudentController::class, 'feedbackHistory']);
Route::get('/student/profile', [StudentController::class, 'profile']);
