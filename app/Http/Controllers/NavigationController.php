<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class NavigationController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param CourseService $service
     */
    public function __construct(
        protected CourseService $service,
    )
    {}

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Course::class);

        $user = auth()->user();
        if ($user->isAdministrator()) {
            $courses = $this->service->paginate(4);
        } else {
            $courses = $user->courses()->paginate(4);
        }

        return view('layouts.navigation', ['courses' => $courses]);
    }
}
