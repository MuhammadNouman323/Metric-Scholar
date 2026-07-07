<?php

namespace App\Http;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AnonymousFeedbackMiddleware;
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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // global middleware left empty intentionally
    ];

    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            SubstituteBindings::class,
        ],
        'api' => [
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    protected $middlewareAliases = [
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
        'auth' => AuthenticateMiddleware::class,
        'session.expired' => SessionExpiredMiddleware::class,
        'redirect.unauthorized' => RedirectUnauthorizedMiddleware::class,
    ];

    protected $routeMiddleware = [
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
        'auth' => AuthenticateMiddleware::class,
    ];
}
