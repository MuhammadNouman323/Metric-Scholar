<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;

class FacultyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return (new RoleMiddleware)->handle($request, $next, Role::Faculty->value);
    }
}
