<?php

namespace App\Http\Controllers\Curator;

use App\Services\CourseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class InternController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request)
    {
        $interns = $this->userService->getCourseInterns(
            auth()->user()->courses()->first()->id
        );

        return view('curator.intern.index', [
            'title' => 'Практиканты',
            'interns' => $interns
        ]);
    }
}
