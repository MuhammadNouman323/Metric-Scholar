<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Accepts a pipe or comma separated list of roles: role:admin|faculty
     */
    public function handle(Request $request, Closure $next, ?string $roles = null)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        $allowed = preg_split('/[|,]/', $roles, -1, PREG_SPLIT_NO_EMPTY);
        $allowed = array_map('strtolower', $allowed);

        $userRole = strtolower((string) auth()->user()->role);

        if (in_array($userRole, $allowed, true)) {
            return $next($request);
        }

        $target = $this->redirectPathForRole($userRole);

        return redirect($target)->with('error', 'You are not authorized to access that page.');
    }

    protected function redirectPathForRole(string $role): string
    {
        return match (strtolower($role)) {
            'admin' => '/admin/dashboard',
            'faculty' => '/faculty/dashboard',
            default => '/student/dashboard',
        };
    }
}
