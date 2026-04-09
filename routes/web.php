<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/users', function () {
    return view('admin.users');
});

Route::get('/admin/students', function () {
    return view('admin.students');
});

Route::get('/admin/faculity', function () {
    return view('admin.faculty');
});

Route::get('/admin/faculty', function () {
    return view('admin.faculty');
});

Route::get('/admin/courses', function () {
    return view('admin.courses');
});
Route::get('/admin/reports', function () {
    return view('admin.reports');
});

Route::get('/faculty/dashboard', function () {
    return view('faculty.dashboard');
});

Route::get('/faculty/feedback', function () {
    return view('faculty.feedback');
});

Route::get('/faculty/analytics', function () {
    return view('faculty.analytics');
});

Route::get('/faculty/profile', function () {
    return view('faculty.profile');
});

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
});

Route::get('/student/courses', function () {
    return view('student.courses');
});

Route::get('/student/feedback', function () {
    return view('student.feedback');
});

Route::get('/student/feedback/history', function () {
    return view('student.feedback.history');
});

Route::get('/student/profile', function () {
    return view('student.profile');
});
