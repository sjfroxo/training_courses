<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use App\Services\CourseService;
use App\Services\StudentsClassService;
use App\Services\UserCourseService;
use App\Services\UserStudyProgressService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserStudyProgressController
{
    use AuthorizesRequests;

    /**
     * @param CourseService $service
     * @param UserCourseService $userCourseService
     * @param StudentsClassService $studentsClassService
     * @param UserStudyProgressService $userStudyProgressService
     */
    public function __construct(
        protected CourseService        $service,
        protected UserCourseService    $userCourseService,
        protected StudentsClassService $studentsClassService,
        protected UserStudyProgressService $userStudyProgressService,
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

        $totalCountCourses = $this->userCourseService->getTotalCountCourses();

        $progress = $this->userStudyProgressService->getProgress();

        $averageUserScore = $this->userStudyProgressService->getAverageUserScore();

        return view('user-study-progress', [
            'curator' => $curator,
            'course' => $course,
            'totalCountCourses' => $totalCountCourses,
            'progress' => $progress,
            'averageUserScore' => $averageUserScore,
        ]);
    }
}
