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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
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
     * @return RedirectResponse
     */
    public function store(ExamUserResponseResultRequest $request): RedirectResponse
    {
        $moduleExamId = $request->input('module_exam_id');
        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);
        $this->authorize('create', [$moduleExam]);
        $userId = auth()->id();

        $moduleExamUserResponseRequest = new ModuleExamUserResponseRequest($request->all());
        $responseDTOs = ModuleExamUserResponseDTO::appRequest($moduleExamUserResponseRequest, $this->questionService);
        $this->responseService->processUserResponses($moduleExamId, $userId, $responseDTOs);

        $results = $this->resultService->calculateResults($moduleExamId);
        $request->merge(['mark' => (string)$results['percent']]);

        $examUserResultRequest = new ExamUserResultRequest($request->all());
        $examResultDTO = ExamUserResultDTO::appRequest($examUserResultRequest);
        $this->resultService->createResult($examResultDTO);

        return redirect()->route('examsUsersResults.index', ['module_exam_id' => $moduleExamId]);
    }

}
