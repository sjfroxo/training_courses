<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $service
     */
    public function __construct(protected CategoryService $service) {}
}
