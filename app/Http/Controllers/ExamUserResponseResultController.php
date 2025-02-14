<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ExamUserResultDTO;
use App\DataTransferObjects\ModuleExamUserResponseDTO;
use App\Http\Requests\ExamUserResponseResultRequest;
use App\Http\Requests\ExamUserResultRequest;
use App\Http\Requests\ModuleExamUserResponseRequest;
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

    protected ModuleExamUserResponseService $responseService;
    protected ExamUserResultService $resultService;
    protected CourseService $courseService;
    protected ModuleExamQuestionService $questionService;

    public function __construct(
        ModuleExamUserResponseService $responseService,
        ExamUserResultService         $resultService,
        CourseService                 $courseService,
        ModuleExamQuestionService     $questionService
    )
    {
        $this->responseService = $responseService;
        $this->resultService = $resultService;
        $this->courseService = $courseService;
        $this->questionService = $questionService;
    }

    /**
     * Объединённое сохранение ответов и результата теста.
     *
     * @param ExamUserResponseResultRequest $request
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function store(ExamUserResponseResultRequest $request)
    {
        $moduleExamId = $request->input('module_exam_id');
        $moduleExams = ModuleExam::all();
        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);

        $userId = auth()->id();

        $moduleExamUserResponseRequest = new ModuleExamUserResponseRequest($request->all());
        $responseDTOs = ModuleExamUserResponseDTO::appRequest($moduleExamUserResponseRequest, $this->questionService);
        $this->responseService->processUserResponses($moduleExamId, $userId, $responseDTOs);

        $results = $this->resultService->calculateResults($moduleExamId);
        $request->merge(['mark' => (string)$results['percent']]);

        $examUserResultRequest = new ExamUserResultRequest($request->all());
        $examResultDTO = ExamUserResultDTO::appRequest($examUserResultRequest);
        $this->resultService->createResult($examResultDTO);

        return view('exams-users-results', [
            'moduleExams' => $moduleExams,
            'moduleExam' => $moduleExam,
            'results' => $results,
            'courses' => $this->courseService->all(),
            'examUserResults' => $this->resultService->all(),
        ]);
    }
}
