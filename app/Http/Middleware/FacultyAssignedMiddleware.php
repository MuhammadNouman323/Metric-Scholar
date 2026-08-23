<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Evaluation;
use Closure;
use Illuminate\Http\Request;

class FacultyAssignedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $user = auth()->user();
        if ($user->role !== Role::Faculty) {
            return redirect($user->role->dashboardRoute())
                ->with('error', 'You are not authorized to access that page.');
        }

        $course = $request->route('course') ?? null;
        $evaluation = $request->route('evaluation') ?? null;

        if ($course) {
            $courseId = is_numeric($course) ? $course : $course->id ?? null;
            $assigned = Course::find($courseId)?->faculty()->where('users.id', $user->id)->exists();
            if (! $assigned) {
                return redirect(Role::Faculty->dashboardRoute())->with('error', 'You are not authorized to access that page.');
            }
        }

        if ($evaluation) {
            $evaluationId = is_numeric($evaluation) ? $evaluation : $evaluation->id ?? null;
            $assigned = Evaluation::find($evaluationId)?->faculty()->where('users.id', $user->id)->exists();
            if (! $assigned) {
                return redirect(Role::Faculty->dashboardRoute())->with('error', 'You are not authorized to access that page.');
            }
        }

        return $next($request);
    }
}
