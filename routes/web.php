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