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
Route::get('/admin/user/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/user/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::get('/admin/user/{user}/recovery', [AdminController::class, 'recoveryUser'])->name('admin.users.recovery');
Route::post('/admin/user/{user}/recovery/email', [AdminController::class, 'sendRecoveryEmail'])->name('admin.users.recovery.email');
Route::post('/admin/user/{user}/recovery/password', [AdminController::class, 'updateTemporaryPassword'])->name('admin.users.recovery.password');
Route::post('/admin/user/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.users.toggle-status');
Route::get('/admin/students', [AdminController::class, 'students']);
Route::get('/admin/faculity', [AdminController::class, 'faculty']);
Route::get('/admin/faculty', [AdminController::class, 'faculty']);
Route::get('/admin/faculty/{faculty}/assign-courses', [AdminController::class, 'assignCourses'])->name('admin.faculty.assign-courses');
Route::post('/admin/faculty/{faculty}/assign-courses', [AdminController::class, 'storeCourseAssignments'])->name('admin.faculty.store-assignments');
Route::get('/admin/courses', [AdminController::class, 'courses'])->name('admin.courses');
Route::get('/admin/courses/new', [AdminController::class, 'newCourse'])->name('admin.courses.newCourse');
Route::post('/admin/courses/new', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
Route::get('/admin/courses/assign-faculty/{department?}', [AdminController::class, 'assignFacultyToCourses'])->name('admin.courses.assign-faculty');
Route::post('/admin/courses/assign-faculty', [AdminController::class, 'storeFacultyAssignments'])->name('admin.courses.store-faculty-assignments');
Route::get('/admin/courses/assign-students/{department?}', [AdminController::class, 'assignStudentsToCourses'])->name('admin.courses.assign-students');
Route::post('/admin/courses/assign-students', [AdminController::class, 'storeStudentAssignments'])->name('admin.courses.store-student-assignments');
Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments');
Route::get('/admin/departments/{department}', [AdminController::class, 'department'])->name('admin.departments.show');
Route::get('/admin/departments/{department}/manage', [AdminController::class, 'manageDepartment'])->name('admin.departments.manage');
Route::get('/admin/departments/{department}/courses/new', [AdminController::class, 'newDepartmentCourse'])->name('admin.departments.courses.new');
Route::get('/admin/departments/{department}/faculty/{faculty}/assign-courses', [AdminController::class, 'assignDepartmentCourses'])->name('admin.departments.faculty.assign-courses');
Route::post('/admin/departments/{department}/faculty/{faculty}/assign-courses', [AdminController::class, 'storeDepartmentCourseAssignments'])->name('admin.departments.faculty.store-assignments');
Route::get('/admin/departments/{department}/enrollment/assign-courses', [AdminController::class, 'assignEnrollmentCourses'])->name('admin.departments.enrollment.assign-courses');
Route::post('/admin/departments/{department}/enrollment/assign-courses', [AdminController::class, 'storeEnrollmentCourseAssignments'])->name('admin.departments.enrollment.store-assignments');
Route::post('/admin/departments/{department}/courses/new', [AdminController::class, 'storeDepartmentCourse'])->name('admin.departments.courses.store');
Route::get('/admin/departments/{department}/courses/{course}/edit', [AdminController::class, 'editDepartmentCourse'])->name('admin.departments.courses.edit');
Route::put('/admin/departments/{department}/courses/{course}', [AdminController::class, 'updateDepartmentCourse'])->name('admin.departments.courses.update');
Route::delete('/admin/departments/{department}/courses/{course}', [AdminController::class, 'destroyDepartmentCourse'])->name('admin.departments.courses.destroy');

Route::get('/admin/reports', [AdminController::class, 'reports']);

Route::get('/faculty/dashboard', [FacultyController::class, 'dashboard']);
Route::get('/faculty/feedback', [FacultyController::class, 'feedback']);
Route::get('/faculty/analytics', [FacultyController::class, 'analytics']);
Route::get('/faculty/profile', [FacultyController::class, 'profile']);

Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
Route::get('/student/courses', [StudentController::class, 'courses'])->name('student.courses');
Route::get('/student/feedback/{course?}', [StudentController::class, 'feedback'])->name('student.feedback');
Route::post('/student/feedback', [StudentController::class, 'storeFeedback'])->name('student.feedback.store');
Route::get('/student/feedback-history', [StudentController::class, 'feedbackHistory'])->name('student.feedback.history');
Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
