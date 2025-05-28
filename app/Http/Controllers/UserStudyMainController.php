<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\StudentsClass;
use App\Services\CalendarService;
use App\Services\CourseService;
use App\Services\StudentsClassService;
use App\Services\UserCourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $chat = null;
        if ($curator) {
            $chat = Chat::query()
                ->where('course_id', $courseId)
                ->where('user_id', Auth::id())
                ->where('curator_id', $curator->id)
                ->first();

            if (!$chat) {
                $baseSlug = 'chat-course-' . $courseId . '-user-' . Auth::id() . '-curator-' . $curator->id;
                $title = 'Чат для курса ' . ($course->title ?? 'Курс ' . $courseId) . ' с ' . $curator->name;
                $slug = Str::slug($baseSlug);
                $attempt = 0;
                $uniqueSlug = $slug;

                while (Chat::query()->where('slug', $uniqueSlug)->where('id', '!=', $chat?->id)->exists()) {
                    $attempt++;
                    $uniqueSlug = Str::slug($baseSlug . '-' . $attempt);
                }

                $chat = Chat::query()->firstOrCreate(
                    [
                        'course_id' => $courseId,
                        'user_id' => Auth::id(),
                        'curator_id' => $curator->id,
                    ],
                    [
                        'title' => $title,
                        'slug' => $uniqueSlug,
                    ]
                );

                if ($chat->wasRecentlyCreated) {
                    $chat->users()->sync([Auth::id(), $curator->id]);
                }
            }
        }

        return view('user-study-main', [
            'curator' => $curator,
            'course' => $course,
            'calendarData' => $calendarData,
            'chat' => $chat,
        ]);
    }
}
