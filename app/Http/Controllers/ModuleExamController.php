<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleExamDTO;
use App\Http\Requests\ModuleExamRequest;
use App\Models\ModuleExam;
use App\Services\ModuleExamService;
use App\Services\QuestionTypeService;
use App\Traits\ModuleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ModuleExamController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param ModuleExamService $service
     * @param QuestionTypeService $questionTypeService
     * @param ModuleService $moduleService
     */
	public function __construct(
		protected ModuleExamService   $service,
		protected QuestionTypeService $questionTypeService,
		protected ModuleService       $moduleService,
	)
	{}

    /**
	 * @param string $id
	 *
	 * @return View
	 * @throws AuthorizationException
	 */

    public function show(string $id): View
    {
        $exam = $this->service->findById($id);

        $questions = $this->service->getQuestions($exam);

        return view('show-module-exam-questions', [
            'moduleExam' => $exam,
            'questions'  => $questions,
        ]);
    }


    /**
	 * @return View
	 * @throws AuthorizationException
	 */
	public function create(): View
	{
		$this->authorize('create', ModuleExam::class);

		return view('create-module-exam', [
			'modules' => $this->moduleService->all()
		]);
	}

	/**
	 * @param ModuleExamRequest $request
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(ModuleExamRequest $request): RedirectResponse
	{
		$this->authorize('create', ModuleExam::class);

		$module = $this->moduleService->findById($request['module_id']);

        $validated = $request->validated();

        $dto = new ModuleExamDTO(
            $validated['module_id'],
            $validated['is_autochecked'],
            $validated['name'],
        );

        $this->service->create($dto);

		return to_route('modules.show', ['slug' => $module->slug]);
	}

	/**
	 * @param string $id
	 *
	 * @return View
	 * @throws AuthorizationException
	 */
	public function edit(string $id): View
	{
		$exam = $this->service->findById($id);

		$this->authorize('update', $exam);

		return view('edit-module-exam', [
			'questions' => $this->service->getQuestions($exam),
			'moduleExam' => $exam,
			'questionTypes' => $this->questionTypeService->all()
		]);
	}

	/**
	 * @param ModuleExamRequest $request
	 * @param string $id
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(ModuleExamRequest $request, string $id): RedirectResponse
	{
		$exam = $this->service->findById($id);

		$this->authorize('update', $exam);

        $entity = $this->service->findById($id);

        $validated = $request->validated();

        $dto = new ModuleExamDTO(
            $validated['module_id'],
            $validated['is_autochecked'],
            $validated['name'],
        );

        $this->service->update($entity, $dto);

		return to_route('moduleExams.show', ['moduleExam' => $id]);
	}

	/**
	 * @param string $id
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function destroy(string $id): RedirectResponse
	{
		$moduleExam = $this->service->firstWithModule($id);

        $moduleExam->delete();

		return to_route('modules.show', ['slug' => $moduleExam->module->slug]);
	}
}
