<?php

namespace App\Http\Controllers\Curator;

use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    public function index()
    {
        return view('curator.grade.index', ['title' => 'Оценки']);
    }
}
