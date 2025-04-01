<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleDTO;
use App\Http\Requests\ModuleRequest;
use App\Models\Course;
use App\Models\Module;
use App\Services\CourseService;
use App\Traits\ModuleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ModuleController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param ModuleService $service
     * @param CourseService $courseService
     */
	public function __construct(
		protected ModuleService $service,
		protected CourseService $courseService,
	)
	{}

	/**
	 * @param string $slug
	 *
	 * @return View
	 * @throws AuthorizationException
	 */
	public function show(string $slug): View
	{
		$module = $this->service->findBySlug($slug);

		$this->authorize('view', $module);

		return view('show-module', [
			'module' => $module,
			'comments' => $module->moduleComments
		]);
	}

	/**
	 * @return View
	 * @throws AuthorizationException
	 */
	public function create(): View
	{
		$courses = $this->courseService->all();

		$this->authorize('create', Module::class);

		return view('create-module', ['courses' => $courses]);
	}

	/**
	 * @param ModuleRequest $request
	 *
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(ModuleRequest $request): RedirectResponse
	{
		$this->authorize('create', Course::class);

        $dto = new ModuleDTO(
            $request->validated()['title'],
            $request->validated()['course_id'],
            $request->validated()['content'],
        );

        $this->service->create($dto);

        $course = $this->service->findCourses()->findOrFail($dto->course_id);

        return to_route('courses.show', ['slug' => $course->slug]);
	}

    /**
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $model = $this->service->firstWithModule($id);

        $module = $model->course;

        $model->delete();

        return to_route('courses.show', ['slug' => $module->slug]);
    }

	/**
	 * @param string $slug
	 *
	 * @return View
	 * @throws AuthorizationException
	 */
	public function edit(string $slug): View
	{
		$module = $this->service->findBySlug($slug);

		$this->authorize('update', $module);

		return view('edit-module', ['module' => $module]);
	}

    /**
     * @param ModuleRequest $request
     * @param string $slug
     * @return RedirectResponse
     */
    public function update(ModuleRequest $request, string $slug): RedirectResponse
    {
        $module = $this->service->findBySlug($slug);

        $this->authorize('update', $module);

        $dto = new ModuleDTO(
            $request->validated()['title'],
            $request->validated()['course_id'],
            $request->validated()['content'],
        );

        $this->service->update($module, $dto);

        $course = Course::query()->findOrFail($module->course_id);

        return to_route('courses.show', ['slug' => $course->slug]);
    }

}

