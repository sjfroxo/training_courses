<?php

namespace App\Http\Controllers\Curator;

use Illuminate\Routing\Controller;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses()->get();

        return view('curator.courses.index', ['title' => 'Курсы', 'courses' => $courses]);
    }
}
