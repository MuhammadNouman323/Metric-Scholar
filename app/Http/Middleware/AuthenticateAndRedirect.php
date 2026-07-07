<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateAndRedirect
{
    /**
     * If not authenticated redirect to login with flash.
     * If authenticated, refresh last_activity and continue.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // refresh last activity timestamp for session expiry tracking
        $request->session()->put('last_activity', now()->timestamp);

        return $next($request);
    }
}
