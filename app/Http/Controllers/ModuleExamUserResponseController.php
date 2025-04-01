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

    public function __construct(
        protected ModuleExamUserResponseService $responseService,
        protected ModuleExamQuestionService     $questionService
    ) {}

    /**
     * Сохранение ответов пользователя.
     *
     * @param ModuleExamUserResponseRequest $request
     * @return RedirectResponse
     */
    public function store(ModuleExamUserResponseRequest $request): RedirectResponse
    {
        $moduleExamId = $request->input('module_exam_id');

        $userId = auth()->id();

        $validated = $request->validated();

        $dto = new ModuleExamUserResponseDTO(
            $validated['module_exam_question_id'],
            $validated['user_id'],
            $validated['module_exam_answer_id'],
            $validated['text'],
            $validated['module_exam_id'],
        );

        $this->responseService->create($dto);

        $this->responseService->processUserResponses($moduleExamId, $userId, (array)$dto);

        return redirect()->route('examsUsersResults.store', ['module_exam_id' => $moduleExamId]);
    }
}
