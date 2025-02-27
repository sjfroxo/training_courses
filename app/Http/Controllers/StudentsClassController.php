<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\StudentsClassDTO;
use App\Http\Requests\StudentsClassRequest;
use App\Models\StudentsClass;
use App\Services\StudentsClassService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StudentsClassController
{
    use AuthorizesRequests;

    /**
     * @param StudentsClassService $service
     */
    public function __construct(
        protected StudentsClassService $service,
    )
    {}

    /**
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', StudentsClass::class);

        $studentsClasses = $this->service->paginate(4);

//        $studentsClasses->getCollection()->load('course');

        return view('students-class', [
            'studentsClasses' => $studentsClasses,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', StudentsClass::class);

        $courses = $this->service->getCourses();

        return view('create-students-class', compact('courses'));
    }

    /**
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $studentsClass = $this->service->findById($id);

        $this->authorize('view', $studentsClass);

        $users = $this->service->getUsers();

        return view('show-students-class', [
            'studentsClass' => $studentsClass,
            'users' => $users,
        ]);
    }

    /**
     * @param StudentsClassRequest $request
     * @return RedirectResponse
     */
    public function store(StudentsClassRequest $request): RedirectResponse
    {
        $this->authorize('create', StudentsClass::class);

        $dto = new StudentsClassDTO(
            $request->validated()['name'],
            (int)$request->validated()['course_id'],
            (int)$request->validated()['curator_id'],
            (array)$request->validated()['student_ids'],
        );

        $this->service->create($dto);

        return to_route('studentsClass.index');
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $model = $this->service->findById($id);

        $this->authorize('delete', $model);

        $this->service->destroyById($id);

        return to_route('studentsClass.index');
    }

    /**
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $studentsClass = $this->service->findById($id);

        $this->authorize('update', $studentsClass);

        return view('edit-studentsClass', ['studentsClass' => $studentsClass]);
    }
}
