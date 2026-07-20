<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class UpdateEvaluationStatuses
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            Artisan::call('evaluation:process-lifecycle');
        } catch (\Throwable $e) {
            // Ignore errors
        }

        return $next($request);
    }
}
