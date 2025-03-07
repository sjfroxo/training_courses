<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ExamUserResultDTO;
use App\Http\Requests\ExamUserResultRequest;
use App\Models\ModuleExam;
use App\Services\CourseService;
use App\Services\ExamUserResultService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        protected CourseService $courseService
    ) {}

    /**
     * @param ExamUserResultRequest $request
     * @return View
     */
    public function index(ExamUserResultRequest $request): View
    {
        $moduleExam = ModuleExam::query()->findOrFail($request->input('module_exam_id'));

        $results = $this->service->calculateResults($moduleExam->id);

        return view('exams-users-results', [
            'moduleExams' => ModuleExam::all(),
            'moduleExam' => $moduleExam,
            'results' => $results,
            'courses' => $this->courseService->all(),
            'examUserResults' => $this->service->all(),
        ]);
    }

    /**
     * @param ExamUserResultRequest $request
     * @return View
     */
    public function store(ExamUserResultRequest $request): View
    {
        $moduleExamId = $request->input('module_exam_id');
        $userId = auth()->id();

        $results = $this->service->calculateResults($moduleExamId);
        $mark = (string) $results['percent'];

        $examResultDTO = new ExamUserResultDTO($userId, $moduleExamId, $mark);
        $this->service->createResult($examResultDTO);

        $moduleExam = ModuleExam::query()->findOrFail($moduleExamId);

        return view('exams-users-results', [
            'moduleExams' => ModuleExam::all(),
            'moduleExam' => $moduleExam,
            'results' => $results,
            'courses' => $this->courseService->all(),
            'examUserResults' => $this->service->all(),
        ]);
    }
}
