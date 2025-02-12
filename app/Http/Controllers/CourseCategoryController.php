<?php

namespace App\Http\Controllers;

use App\Services\CourseCategoryService;
use Illuminate\Routing\Controller;

class CourseCategoryController extends Controller
{
    /**
     * @param CourseCategoryService $service
     */
    public function __construct(CourseCategoryService $service) {}
}
