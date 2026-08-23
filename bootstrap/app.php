<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthenticateAndRedirect;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\FacultyAssignedMiddleware;
use App\Http\Middleware\FacultyMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SecurityHeadersMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\UpdateEvaluationStatuses;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        channels: __DIR__.'/../routes/channels.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecurityHeadersMiddleware::class);
        $middleware->append(UpdateEvaluationStatuses::class);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'admin' => AdminMiddleware::class,
            'faculty' => FacultyMiddleware::class,
            'student' => StudentMiddleware::class,
            'faculty.assigned' => FacultyAssignedMiddleware::class,
            'auth.redirect' => AuthenticateAndRedirect::class,
            'auth' => AuthenticateMiddleware::class,
        ]);

        // Redirect authenticated users on guest routes to their role dashboard
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (auth()->check()) {
                return auth()->user()->role->dashboardRoute();
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
