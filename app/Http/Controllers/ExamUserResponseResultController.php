<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ExamUserResultDTO;
use App\Http\Requests\ExamUserResponseResultRequest;
use App\Models\ModuleExam;
use App\Services\CourseService;
use App\Services\ExamUserResultService;
use App\Services\ModuleExamQuestionService;
use App\Services\ModuleExamUserResponseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class ExamUserResponseResultController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param ModuleExamUserResponseService $responseService
     * @param ExamUserResultService $resultService
     * @param CourseService $courseService
     * @param ModuleExamQuestionService $questionService
     */
    public function __construct(
        protected ModuleExamUserResponseService $responseService,
        protected ExamUserResultService         $resultService,
        protected CourseService                 $courseService,
        protected ModuleExamQuestionService     $questionService
    )
    {}

    /**
     * Объединённое сохранение ответов и результата теста.
     *
     * @param ExamUserResponseResultRequest $request
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function store(ExamUserResponseResultRequest $request)
    {
        $moduleExamId = $request->input('module_exam_id');

        $userId = auth()->id();

        $this->responseService->handleUserResponses($request, $userId);

        $results = $this->resultService->calculateResults($moduleExamId);

        $this->resultService->createResult(new ExamUserResultDTO($userId, $moduleExamId, $results['percent']));

        return view('exams-users-results', [
            'moduleExam' => ModuleExam::query()->findOrFail($moduleExamId),
            'results' => $results,
            'courses' => $this->courseService->all(),
            'examUserResults' => $this->resultService->all(),
        ]);
    }
}
