<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return (new RoleMiddleware)->handle($request, $next, 'admin');
    }
}
