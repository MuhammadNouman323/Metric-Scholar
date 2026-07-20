<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AnonymousFeedbackMiddleware;
use App\Http\Middleware\AuthenticateAndRedirect;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\EvaluationActiveMiddleware;
use App\Http\Middleware\EvaluationDeadlineMiddleware;
use App\Http\Middleware\FacultyAssignedMiddleware;
use App\Http\Middleware\FacultyMiddleware;
use App\Http\Middleware\FeedbackSubmittedMiddleware;
use App\Http\Middleware\RedirectUnauthorizedMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SessionExpiredMiddleware;
use App\Http\Middleware\StudentEnrollmentMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\UpdateEvaluationStatuses;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            UpdateEvaluationStatuses::class,
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'admin' => AdminMiddleware::class,
            'faculty' => FacultyMiddleware::class,
            'student' => StudentMiddleware::class,
            'evaluation.active' => EvaluationActiveMiddleware::class,
            'evaluation.deadline' => EvaluationDeadlineMiddleware::class,
            'feedback.submitted' => FeedbackSubmittedMiddleware::class,
            'student.enrolled' => StudentEnrollmentMiddleware::class,
            'faculty.assigned' => FacultyAssignedMiddleware::class,
            'anonymous.feedback' => AnonymousFeedbackMiddleware::class,
            'auth.redirect' => AuthenticateAndRedirect::class,
            'auth' => AuthenticateMiddleware::class,
            'session.expired' => SessionExpiredMiddleware::class,
            'redirect.unauthorized' => RedirectUnauthorizedMiddleware::class,
        ]);

        // Redirect authenticated users on guest routes to their role dashboard
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (auth()->check()) {
                $role = strtolower((string) auth()->user()->role);

                return match ($role) {
                    'admin' => '/admin/dashboard',
                    'faculty' => '/faculty/dashboard',
                    default => '/student/dashboard',
                };
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
