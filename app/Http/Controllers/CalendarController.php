<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVisit;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function showCalendar($courseId, $month = null, $year = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $this->renderCalendar(Auth::user()->id, $courseId, $month, $year, 'user-study');
    }

    public function showUserActivity($userId, $courseId, $month = null, $year = null)
    {
        if (!Auth::check() || !Auth::user()->isAdministrator()) {
            return redirect()->route('home');
        }

        return $this->renderCalendar($userId, $courseId, $month, $year, 'users.show');
    }

    private function renderCalendar($userId, $courseId, $month, $year, $viewName)
    {
        $currentDate = Carbon::now();
        $month = $month ?? $currentDate->format('m');
        $year = $year ?? $currentDate->format('Y');

        if (!is_numeric($month) || $month < 1 || $month > 12) {
            $month = $currentDate->format('m');
        }
        if (!is_numeric($year) || $year < 1900 || $year > 2100) {
            $year = $currentDate->format('Y');
        }

        $firstDay = Carbon::createFromDate($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $daysInMonth = $lastDay->day;
        $startingDay = (int)$firstDay->dayOfWeek;

        $visits = CourseVisit::query()->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereYear('visit_date', $year)
            ->whereMonth('visit_date', $month)
            ->pluck('visit_date')
            ->map(function ($date) {
                return (int)$date->format('d');
            })
            ->toArray();

        $course = Course::query()->findOrFail($courseId);
        $user = User::query()->findOrFail($userId);
        $calendarHtml = $this->generateCalendarHtml($firstDay, $daysInMonth, $startingDay, $visits, $month, $year, $userId, $courseId);

        return view('user-study', [
            'user' => $user,
            'course' => $course,
            'courseId' => $courseId,
            'calendarHtml' => $calendarHtml,
        ]);
    }

    private function generateCalendarHtml($firstDay, $daysInMonth, $startingDay, $activeDays, $month, $year, $userId, $courseId)
    {
        $daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $prevMonth = $month == 1 ? 12 : $month - 1;
        $prevYear = $month == 1 ? $year - 1 : $year;
        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $html = '<div class="d-flex justify-content-between mb-2">';
        foreach ($daysOfWeek as $day) {
            $html .= '<div class="text-center fw-bold">' . $day . '</div>';
        }
        $html .= '</div>';
        $html .= '<div class="d-flex flex-wrap">';

        $startingDay = $startingDay === 0 ? 7 : $startingDay;

        for ($i = 1; $i < $startingDay; $i++) {
            $html .= '<div class="p-2 flex-fill text-center"></div>';
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $isActive = in_array($day, $activeDays);
            $html .= '<div class="p-2 flex-fill text-center ' . ($isActive ? 'bg-primary text-white' : '') . ' rounded">' . $day . '</div>';
        }

        $html .= '</div>';
        $html .= '<div class="d-flex justify-content-between mt-2">';
        $html .= '<a href="' . route('admin.user.activity', [$userId, $courseId, $prevMonth, $prevYear]) . '" class="btn btn-sm btn-outline-secondary"> < Февраль 2025</a>';
        $html .= '<span>' . $firstDay->format('F Y') . '</span>';
        $html .= '<a href="' . route('admin.user.activity', [$userId, $courseId, $nextMonth, $nextYear]) . '" class="btn btn-sm btn-outline-secondary">Март 2025 ></a>';
        $html .= '</div>';

        return $html;
    }
}
