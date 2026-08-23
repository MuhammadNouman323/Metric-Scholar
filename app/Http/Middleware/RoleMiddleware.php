<?php

namespace App\Http\Middleware;

use App\Enums\Role;
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
        $allowed = array_map(fn ($r) => strtolower($r), $allowed);

        $userRole = strtolower(auth()->user()->role->value);

        if (in_array($userRole, $allowed, true)) {
            return $next($request);
        }

        $target = $this->redirectPathForRole(auth()->user()->role);

        return redirect($target)->with('error', 'You are not authorized to access this page.');
    }

    protected function redirectPathForRole(Role $role): string
    {
        return $role->dashboardRoute();
    }
}
