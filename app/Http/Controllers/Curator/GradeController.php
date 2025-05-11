<?php

namespace App\Http\Controllers\Curator;

use App\Services\TaskAnswerService;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    public function __construct(protected TaskAnswerService $taskAnswerService) {}

    public function index()
    {
        $answers = $this->taskAnswerService->getForCurator();

        return view('curator.grade.index', [
            'title' => 'Оценки',
            'answers' => $answers
        ]);
    }
}
