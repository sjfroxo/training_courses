<?php

namespace App\Http\Controllers;

use App\Services\QuestionTypeService;
use Illuminate\Routing\Controller;

class QuestionTypeController extends Controller
{
	/**
	 * @param QuestionTypeService $service
	 */
	public function __construct(QuestionTypeService $service) {}
}
