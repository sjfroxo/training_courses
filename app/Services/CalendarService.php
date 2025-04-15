<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class CalendarService
{
    public function generateCalendar(?int $month = null, ?int $year = null): array
    {
        $now = Carbon::now();
        $month = $month ?? $now->month;
        $year = $year ?? $now->year;

        $firstDay = Carbon::create($year, $month, 1);
        $prevMonth = $firstDay->copy()->subMonth();
        $nextMonth = $firstDay->copy()->addMonth();

        return [
            'firstDay' => $firstDay,
            'prevMonth' => $prevMonth->month,
            'prevYear' => $prevMonth->year,
            'nextMonth' => $nextMonth->month,
            'nextYear' => $nextMonth->year,
            'startingDay' => $firstDay->dayOfWeekIso,
            'daysInMonth' => $firstDay->daysInMonth,
            'activeDays' => [1, 5, 10, 15, 20, 25], // Пример активных дней
        ];
    }
}
