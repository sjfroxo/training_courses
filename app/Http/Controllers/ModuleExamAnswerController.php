<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleExamAnswerDTO;
use App\Http\Requests\ModuleExamAnswerRequest;
use App\Models\ModuleExamAnswer;
use App\Services\ModuleExamAnswerService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class  ModuleExamAnswerController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param ModuleExamAnswerService $service
     */
    public function __construct(
        protected ModuleExamAnswerService $service,
    )
    {
    }

    /**
     * @param ModuleExamAnswerRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ModuleExamAnswerRequest $request): RedirectResponse
    {
        $this->authorize('create', ModuleExamAnswer::class);

        $validated = $request->validated();

        $dto = new ModuleExamAnswerDTO(
            $validated['value'],
            $validated['module_exam_question_id'],
            ($validated['is_correct'] ?? 0),
            $validated['module_exam_id']
        );

        $this->service->create($dto);

        return back();
    }

    /**
     * @param string $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(string $id): RedirectResponse
    {
        $model = $this->service->findById($id);

        $this->authorize('delete', $model);

        $this->service->destroyById($id);

        return back();
    }

    /**
     * @param ModuleExamAnswerRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ModuleExamAnswerRequest $request, string $id): RedirectResponse
    {
        $moduleExamAnswer = $this->service->findById($id);

        $this->authorize('update', $moduleExamAnswer);

        $entity = $this->service->findById($id);

        $validated = $request->validated();

        $dto = new ModuleExamAnswerDTO(
            $validated['value'],
            $validated['module_exam_question_id'],
            ($validated['is_correct'] ?? 0),
            $validated['module_exam_id']
        );

        $this->service->update($entity, $dto);

        return back();
    }
}
