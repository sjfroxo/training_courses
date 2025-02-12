<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ExamUserResultDTO;
use App\Http\Requests\ExamUserResultRequest;
use App\Models\ModuleExam;
use App\Services\CourseService;
use App\Services\ExamUserResultService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExamUserResultController extends Controller
{
    use AuthorizesRequests;

	/**
	 * @param ExamUserResultService $service
	 * @param CourseService $courseService
	 */
	public function __construct(
        protected ExamUserResultService $service,
        protected CourseService         $courseService
    ) {}

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $moduleExams = ModuleExam::all();

        $moduleExam = ModuleExam::query()->findOrFail($request->input('module_exam_id'));

        $this->authorize('create', [$moduleExam]);

        $results = $this->service->calculateResults($moduleExam->id);

        return view('exams-users-results', [
            'moduleExams' => $moduleExams,
            'moduleExam' => $moduleExam,
            'results' => $results,
            'courses' => $this->courseService->all(),
            'examUserResults' => $this->service->all(),
        ]);
    }

    public function store(ExamUserResultRequest $request)
    {
        dd($request->all());

        $dto = ExamUserResultDTO::appRequest($request);

        $this->service->createResult($dto);

        $moduleExamId = $request->input('module_exam_id');

        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);

        $this->authorize('create', [$moduleExam]);

        $results = $this->service->calculateResults($moduleExam->id);

        return redirect()->route('examsUsersResults.index', ['module_exam_id' => $dto->module_exam_id]);
    }

}
