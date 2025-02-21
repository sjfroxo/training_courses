<?php

namespace App\Http\Middleware;

use App\Models\CourseVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogCourseVisit
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->route('slug')) { // Извлекаем slug курса из маршрута
            $course = \App\Models\Course::where('slug', $request->route('slug'))->firstOrFail();
            $user = Auth::user();

            $visitExists = CourseVisit::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->whereDate('visit_date', now()->toDateString())
                ->exists();

            if (!$visitExists) {
                CourseVisit::query()->create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'visit_date' => now()->toDateString(),
                ]);
            }
        }

        return $next($request);
    }
}
