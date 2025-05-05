<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\StudentsClassDTO;
use App\Http\Requests\CuratorRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentsClassRequest;
use App\Models\StudentsClass;
use App\Services\StudentsClassService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StudentsClassController
{
    use AuthorizesRequests;

    /**
     * @param StudentsClassService $service
     * @param UserService $userService
     */
    public function __construct(
        protected StudentsClassService $service,
        protected UserService          $userService
    )
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', StudentsClass::class);

        $studentsClasses = $this->service->paginate(12);

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

        $courses = $this->service->all();

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

        $users = $this->userService->getUsers();

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

        $validated = $request->validated();

        $dto = new StudentsClassDTO(
            $validated['name'],
            $validated['course_id'],
            $validated['curator_id'],
            $validated['student_ids'],
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

    public function update(StudentsClassRequest $request, StudentsClass $studentsClass): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new StudentsClassDTO(
            $validated['name'],
            $validated['course_id'],
            $validated['curator_id'],
            $validated['student_ids'],
        );

        $this->service->update($studentsClass, $dto);

        return redirect()->route('studentsClass.index');
    }

    /**
     * @param StudentRequest $request
     * @param StudentsClass $studentsClass
     * @return RedirectResponse
     */
    public function addStudents(StudentRequest $request, StudentsClass $studentsClass): RedirectResponse
    {
        $studentIds = $request->validated()['student_ids'];

        $this->service->addStudents($studentsClass, $studentIds);

        return redirect()->route('studentsClass.show', $studentsClass->id);
    }

    /**
     * @param CuratorRequest $request
     * @param StudentsClass $studentsClass
     * @return RedirectResponse
     */
    public function addCurator(CuratorRequest $request, StudentsClass $studentsClass): RedirectResponse
    {
        $curatorId = $request->validated('curator_id');

        $this->service->addCurator($studentsClass, $curatorId);

        return to_route('studentsClass.show', $studentsClass->id);
    }


    public function deleteUser(StudentsClass $studentsClass, int $userId): RedirectResponse
    {
        $this->authorize('update', $studentsClass);

        $this->service->removeStudent($studentsClass, $userId);

        return redirect()->route('studentsClass.show', $studentsClass->id);
    }

}
