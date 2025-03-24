<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\StudentsClass;
use App\Services\CourseService;
use App\Services\StudentsClassService;
use App\Services\UserCourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserStudyTasksController
{
    use AuthorizesRequests;

    /**
     * @param CourseService $service
     * @param UserCourseService $userCourseService
     * @param StudentsClassService $studentsClassService
     */
    public function __construct(
        protected CourseService        $service,
        protected UserCourseService    $userCourseService,
        protected StudentsClassService $studentsClassService,
    )
    {
    }


    /**
     * @param int $courseId
     * @return Factory|View|Application
     */
    public function show(int $courseId): Factory|View|Application
    {
        $course = $this->service->findById($courseId);

        $studentsClass = StudentsClass::query()->where('course_id', $courseId)->first();

        $curator = $studentsClass ? $this->studentsClassService->getCuratorForClass($studentsClass->id) : null;
        return view('user-study-tasks', [
            'curator' => $curator,
            'course' => $course,
        ]);
    }
}
