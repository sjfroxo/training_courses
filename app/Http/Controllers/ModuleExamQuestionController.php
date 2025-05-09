<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleExamQuestionDTO;
use App\Http\Requests\ModuleExamQuestionRequest;
use App\Models\ModuleExamQuestion;
use App\Services\ModuleExamQuestionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ModuleExamQuestionController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param ModuleExamQuestionService $service
     */
    public function __construct(
        protected ModuleExamQuestionService $service,
    )
    {}

    /**
     * @param ModuleExamQuestionRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ModuleExamQuestionRequest $request): RedirectResponse
    {
        $this->authorize('create', ModuleExamQuestion::class);

        $validated = $request->validated();

        $dto = new ModuleExamQuestionDTO(
            $validated['text'],
            $validated['module_exam_id'],
            $validated['question_type_id'],
        );

        $this->service->create($dto);

        return back();
    }

    /**
     * @param string $id
     *
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
     * @param ModuleExamQuestionRequest $request
     * @param string $id
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ModuleExamQuestionRequest $request, string $id): RedirectResponse
    {
        $moduleExamQuestion = $this->service->findById($id);

        $this->authorize('update', $moduleExamQuestion);

        $entity = $this->service->findById($id);

        $validated = $request->validated();

        $dto = new ModuleExamQuestionDTO(
            $validated['text'],
            $validated['module_exam_id'],
            $validated['question_type_id'],
        );

        $this->service->update($entity, $dto);

        return back();
    }
}
