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

    public function __construct(
        protected StudentsClassService $service,
    )
    {}

    public function index(): View
    {
        $this->authorize('viewAny', StudentsClass::class);

        $studentsClasses = $this->service->paginate(4);

        return view('students-class', ['studentsClasses' => $studentsClasses]);
    }

    public function create(): View
    {
        $this->authorize('create', StudentsClass::class);

        return view('create-students-class');
    }

    public function store(StudentsClassRequest $request): RedirectResponse
    {
        $this->authorize('create', StudentsClass::class);

        $dto = new StudentsClassDTO(
            $request->validated()['name'],
            (int)$request->validated()['course_id'],
            (int)$request->validated()['curator_id'],
            (array)$request->validated()['student_ids'],
            (int)$request->validated()['user_role_id'],
        );

        $this->service->create($dto);

        return to_route('studentsClass');
    }
}
