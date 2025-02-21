<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class StudentsClassController
{
    use AuthorizesRequests;

    public function __construct(
    )
    {}

    public function index()
    {
        $studentsClasses = StudentsClass::all();

        return view('students-class', ['studentsClasses' => $studentsClasses]);
    }
}
