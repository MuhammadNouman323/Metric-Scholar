<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', Login::class);
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', Register::class)
    ->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/logout', Logout::class)->name('logout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/users', [AdminController::class, 'users']);
Route::get('/admin/students', [AdminController::class, 'students']);
Route::get('/admin/faculity', [AdminController::class, 'faculty']);
Route::get('/admin/faculty', [AdminController::class, 'faculty']);
Route::get('/admin/courses', [AdminController::class, 'courses']);
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
