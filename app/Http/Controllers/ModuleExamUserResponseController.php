<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ModuleExamUserResponseDTO;
use App\Http\Requests\ModuleExamUserResponseRequest;
use App\Models\ModuleExam;
use App\Services\CourseService;
use App\Services\ModuleExamQuestionService;
use App\Services\ModuleExamUserResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleExamUserResponseController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected ModuleExamUserResponseService $service,
        protected Request                       $request,
        protected CourseService           $courseService,
    )
    {
    }

    /**
     * @param ModuleExamUserResponseRequest $request
     * @param ModuleExamQuestionService $service
     * @return RedirectResponse
     */

    public function store(ModuleExamUserResponseRequest $request, ModuleExamQuestionService $service): RedirectResponse
    {
//        dd($request->all());
        $moduleExamId = $request->input('module_exam_id');
        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);

        $this->authorize('create', [$moduleExam]);

        $userId = auth()->id();
        $dtos = ModuleExamUserResponseDTO::appRequest($request, $service);

        $this->service->processUserResponses($moduleExamId, $userId, $dtos);

        return redirect()->route('examsUsersResults.index', ['module_exam_id' => $moduleExamId]);
    }
}
