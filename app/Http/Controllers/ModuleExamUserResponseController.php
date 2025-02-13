<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\ModuleExamUserResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class ModuleExamUserResponseController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param ModuleExamUserResponseService $service
     * @param CourseService $courseService
     */
    public function __construct(
        protected ModuleExamUserResponseService $service,
        protected CourseService           $courseService,
    )
    {
    }
}
