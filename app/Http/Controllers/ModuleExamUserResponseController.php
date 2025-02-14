<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleExamUserResponseDTO;
use App\Http\Requests\ModuleExamUserResponseRequest;
use App\Models\ModuleExam;
use App\Services\ModuleExamQuestionService;
use App\Services\ModuleExamUserResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ModuleExamUserResponseController extends Controller
{
    use AuthorizesRequests;

    protected ModuleExamUserResponseService $responseService;
    protected ModuleExamQuestionService $questionService;

    public function __construct(
        ModuleExamUserResponseService $responseService,
        ModuleExamQuestionService     $questionService
    ) {
        $this->responseService = $responseService;
        $this->questionService = $questionService;
    }

    /**
     * Сохранение ответов пользователя.
     *
     * @param ModuleExamUserResponseRequest $request
     * @return RedirectResponse
     */
    public function store(ModuleExamUserResponseRequest $request): RedirectResponse
    {
        $moduleExamId = $request->input('module_exam_id');
        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);

//        dd($moduleExam);
//        $this->authorize('create', [$moduleExam]);

        $userId = auth()->id();
        $responseDTOs = ModuleExamUserResponseDTO::appRequest($request, $this->questionService);

        $this->responseService->processUserResponses($moduleExamId, $userId, $responseDTOs);

        return redirect()->route('examsUsersResults.store', ['module_exam_id' => $moduleExamId]);
    }
}
