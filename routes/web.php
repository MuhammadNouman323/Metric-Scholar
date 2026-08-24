<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.attempt');
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', [AuthController::class, 'register']);
// ->middleware(['guest', 'throttle:5,30'])

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    // ->middleware('throttle:3,30')
    ->name('password.email');

Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])
    ->name('password.update');

Route::prefix('admin')
    ->middleware(['auth.redirect', 'admin'])
    ->group(function () {
        Route::put('/profile/password/{user?}', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
        Route::post('/profile/avatar/remove/{user?}', [ProfileController::class, 'removeAvatar'])->name('admin.profile.avatar.remove');
        Route::get('/profile/{user?}', [ProfileController::class, 'showAdminProfile'])->name('admin.profile');
        Route::put('/profile/{user?}', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');

        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/user', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/user', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/user/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/user/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::get('/user/{user}/recovery', [AdminController::class, 'recoveryUser'])->name('admin.users.recovery');
        Route::post('/user/{user}/recovery/email', [AdminController::class, 'sendRecoveryEmail'])->name('admin.users.recovery.email');
        Route::post('/user/{user}/recovery/password', [AdminController::class, 'updateTemporaryPassword'])->name('admin.users.recovery.password');
        Route::post('/user/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
        Route::get('/faculty', [AdminController::class, 'faculty'])->name('admin.faculty');
        Route::get('/faculty/{faculty}/assign-courses', [AdminController::class, 'assignCourses'])->name('admin.faculty.assign-courses');
        Route::post('/faculty/{faculty}/assign-courses', [AdminController::class, 'storeCourseAssignments'])->name('admin.faculty.store-assignments');
        Route::get('/courses', [AdminController::class, 'courses'])->name('admin.courses');
        Route::get('/courses/new', [AdminController::class, 'newCourse'])->name('admin.courses.newCourse');
        Route::post('/courses/new', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
        Route::get('/courses/assign-faculty/{department?}', [AdminController::class, 'assignFacultyToCourses'])->name('admin.courses.assign-faculty');
        Route::post('/courses/assign-faculty', [AdminController::class, 'storeFacultyAssignments'])->name('admin.courses.store-faculty-assignments');
        Route::get('/courses/assign-students/{department?}', [AdminController::class, 'assignStudentsToCourses'])->name('admin.courses.assign-students');
        Route::post('/courses/assign-students', [AdminController::class, 'storeStudentAssignments'])->name('admin.courses.store-student-assignments');
        Route::get('/departments', [AdminController::class, 'departments'])->name('admin.departments');
        Route::get('/departments/{department}', [AdminController::class, 'department'])->name('admin.departments.show');
        Route::get('/departments/{department}/manage', [AdminController::class, 'manageDepartment'])->name('admin.departments.manage');
        Route::get('/departments/{department}/courses/new', [AdminController::class, 'newDepartmentCourse'])->name('admin.departments.courses.new');
        Route::get('/departments/{department}/faculty/{faculty}/assign-courses', [AdminController::class, 'assignDepartmentCourses'])->name('admin.departments.faculty.assign-courses');
        Route::post('/departments/{department}/faculty/{faculty}/assign-courses', [AdminController::class, 'storeDepartmentCourseAssignments'])->name('admin.departments.faculty.store-assignments');
        Route::get('/departments/{department}/enrollment/assign-courses', [AdminController::class, 'assignEnrollmentCourses'])->name('admin.departments.enrollment.assign-courses');
        Route::post('/departments/{department}/enrollment/assign-courses', [AdminController::class, 'storeEnrollmentCourseAssignments'])->name('admin.departments.enrollment.store-assignments');
        Route::post('/departments/{department}/courses/new', [AdminController::class, 'storeDepartmentCourse'])->name('admin.departments.courses.store');
        Route::get('/departments/{department}/courses/{course}/edit', [AdminController::class, 'editDepartmentCourse'])->name('admin.departments.courses.edit');
        Route::put('/departments/{department}/courses/{course}', [AdminController::class, 'updateDepartmentCourse'])->name('admin.departments.courses.update');
        Route::delete('/departments/{department}/courses/{course}', [AdminController::class, 'destroyDepartmentCourse'])->name('admin.departments.courses.destroy');

        Route::get('/evaluations', [AdminController::class, 'evaluations'])->name('admin.evaluations');
        Route::get('/evaluations/new', [AdminController::class, 'newEvaluationStep1'])->name('admin.evaluations.new.step1');
        Route::post('/evaluations/new/step1', [AdminController::class, 'storeEvaluationStep1'])->name('admin.evaluations.new.storeStep1');
        Route::get('/evaluations/new/step2', [AdminController::class, 'newEvaluationStep2'])->name('admin.evaluations.new.step2');
        Route::post('/evaluations/new/step2', [AdminController::class, 'storeEvaluationStep2'])->name('admin.evaluations.new.storeStep2');
        Route::get('/evaluations/new/step3', [AdminController::class, 'newEvaluationStep3'])->name('admin.evaluations.new.step3');
        Route::post('/evaluations/new/publish', [AdminController::class, 'publishEvaluation'])->name('admin.evaluations.new.publish');
        Route::get('/evaluations/{evaluation}/edit', [AdminController::class, 'editEvaluation'])->name('admin.evaluations.edit');
        Route::put('/evaluations/{evaluation}', [AdminController::class, 'updateEvaluation'])->name('admin.evaluations.update');
        Route::get('/evaluations/api/faculty-courses', [AdminController::class, 'getFacultyCoursesForEvaluation'])->name('admin.evaluations.api.faculty-courses');

        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('admin.reports.print');
        Route::get('/reports/export/{format}', [ReportController::class, 'export'])->name('admin.reports.export');
        Route::get('/reports/generate-pdf', [ReportController::class, 'generatePdf'])->name('admin.reports.generate-pdf');
        Route::get('/moderation', [AdminController::class, 'moderation'])->name('admin.moderation');
    });

Route::prefix('faculty')
    ->middleware(['auth.redirect', 'faculty'])
    ->group(function () {
        Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
        Route::get('/feedback', [FacultyController::class, 'feedback'])->name('faculty.feedback');
        Route::get('/analytics', [FacultyController::class, 'analytics'])->name('faculty.analytics');
        Route::put('/profile/password/{user?}', [ProfileController::class, 'updatePassword'])->name('faculty.profile.password');
        Route::post('/profile/avatar/remove/{user?}', [ProfileController::class, 'removeAvatar'])->name('faculty.profile.avatar.remove');
        Route::get('/profile/{user?}', [ProfileController::class, 'showFacultyProfile'])->name('faculty.profile');
        Route::put('/profile/{user?}', [ProfileController::class, 'updateProfile'])->name('faculty.profile.update');
    });

Route::prefix('student')
    ->middleware(['auth.redirect', 'student'])
    ->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/courses', [StudentController::class, 'courses'])->name('student.courses');
        Route::get('/feedback/api/course-details/{course}', [StudentController::class, 'getCourseDetails'])->name('student.feedback.api.course-details');
        Route::get('/feedback/{course?}', [StudentController::class, 'feedback'])->name('student.feedback');
        Route::post('/feedback', [StudentController::class, 'storeFeedback'])
            ->middleware('throttle:10,1')
            ->name('student.feedback.store');
        Route::get('/feedback-history', [StudentController::class, 'feedbackHistory'])->name('student.feedback.history');
        Route::put('/profile/password/{user?}', [ProfileController::class, 'updatePassword'])->name('student.profile.password');
        Route::post('/profile/avatar/remove/{user?}', [ProfileController::class, 'removeAvatar'])->name('student.profile.avatar.remove');
        Route::get('/profile/{user?}', [ProfileController::class, 'showStudentProfile'])->name('student.profile');
        Route::put('/profile/{user?}', [ProfileController::class, 'updateProfile'])->name('student.profile.update');
        Route::get('/teachers', [StudentController::class, 'teachers'])->name('student.teachers');
    });

// Global fallback: avoid Laravel 404/exception pages for role-based areas.
Route::fallback(function () {
    if (auth()->check()) {
        return redirect(auth()->user()->role->dashboardRoute());
    }

    return redirect()->route('login')->with('error', 'Please login to continue.');
});
