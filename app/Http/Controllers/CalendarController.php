<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Throwable;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService) {}

    /**
     * Возвращает HTML календаря по AJAX
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getCalendar(Request $request): JsonResponse
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $calendarData = $this->calendarService->generateCalendar($month, $year);

        $html = view('partials.calendar', compact('calendarData'))->render();

        return response()->json([
            'html' => $html,
        ]);
    }
}

