<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use App\Services\CalendarService;
use App\Services\CourseService;
use App\Services\StudentsClassService;
use App\Services\UserCourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class UserStudyMainController
{
    protected CourseService $service;
    protected UserCourseService $userCourseService;
    protected StudentsClassService $studentsClassService;
    protected CalendarService $calendarService;

    public function __construct(
        CourseService $service,
        UserCourseService $userCourseService,
        StudentsClassService $studentsClassService,
        CalendarService $calendarService
    ) {
        $this->service = $service;
        $this->userCourseService = $userCourseService;
        $this->studentsClassService = $studentsClassService;
        $this->calendarService = $calendarService;
    }

    public function show(int $courseId, ?int $month = null, ?int $year = null): Factory|View|Application
    {
        $course = $this->service->findById($courseId);
        $studentsClass = StudentsClass::query()->where('course_id', $courseId)->first();
        $curator = $studentsClass ? $this->studentsClassService->getCuratorForClass($studentsClass->id) : null;

        $calendarData = $this->calendarService->generateCalendar($month, $year);

        return view('user-study-main', [
            'curator' => $curator,
            'course' => $course,
            'calendarData' => $calendarData,
        ]);
    }
}
