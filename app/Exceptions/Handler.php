<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Handle not found: redirect to appropriate dashboard or login
        if ($e instanceof NotFoundHttpException) {
            if (auth()->check()) {
                $role = strtolower((string) auth()->user()->role);

                return redirect('/'.$role.'/dashboard');
            }

            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if ($e instanceof AuthorizationException) {
            if (auth()->check()) {
                $role = strtolower((string) auth()->user()->role);

                return redirect('/'.$role.'/dashboard')->with('error', 'You are not authorized to access that page.');
            }

            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        return parent::render($request, $e);
    }
}
