<?php

namespace App\Http\Controllers;

use App\Actions\CalculateAverageMarkAction;
use App\DataTransferObjects\CourseDTO;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use App\Services\ExamUserResultService;
use App\Services\UserCourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class CourseController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param CourseService $service
     * @param UserCourseService $userCourseService
     * @param CalculateAverageMarkAction $action
     */
    public function __construct(
        protected CourseService              $service,
        protected UserCourseService          $userCourseService,
        protected CalculateAverageMarkAction $action,
    ) {}

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Course::class);

        $user = auth()->user();
        if ($user->isAdministrator()) {
            $courses = $this->service->paginate(4);
        } else {
            $courses = $user->courses()->paginate(4);
        }

        return view('courses', ['courses' => $courses]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Course::class);

        return view('create-course');
    }

    /**
     * @param string $slug
     *
     * @return View
     * @throws AuthorizationException
     */
    public function show(string $slug): View
    {
        $course = $this->service->findBySlug($slug);

        $progress = $this->userCourseService->getProgress();

        $this->authorize('view', $course);

        return view('show-courses', ['course' => $course, 'progress' => $progress]);
    }

    /**
     * @param CourseRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(CourseRequest $request): RedirectResponse
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('course_avatars');
        }

        $dto = new CourseDTO(
            $validated['title'],
            $validated['description'],
            $path ?? null
        );

        $this->service->create($dto);

        return to_route('courses');
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

        return to_route('courses');
    }

    /**
     * @param string $slug
     *
     * @return View
     * @throws AuthorizationException
     */
    public function edit(string $slug): View
    {
        $course = $this->service->findBySlug($slug);

        $this->authorize('update', $course);

        return view('edit-course', ['course' => $course]);
    }

    /**
     * @param CourseRequest $request
     * @param string $slug
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(CourseRequest $request, string $slug): RedirectResponse
    {
        $course = $this->service->findBySlug($slug);

        $this->authorize('update', $course);

        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('course_avatars');
        }

        $dto = new CourseDTO(
            $validated['title'],
            $validated['description'],
            $path ?? null,
        );

        $this->service->update($course, $dto);

        return to_route('courses');
    }

    /**
     * @param string $slug
     *
     * @return View
     */
    public function showUsers(string $slug): View
    {
        $course = $this->service->findBySlug($slug);

        $users = $course->users;

        $numberCourseExams = $this->service->countCourseExams($slug);

        $numberPassedCourseExamsByUsers = $this->service->countPassedCourseExamsByUsers($slug);

        $averageMark = $this->action->handle($slug);

        $percentPassedCourseExams = $this->service->calculatePercentPassedCourseExams($numberCourseExams, $numberPassedCourseExamsByUsers);

        return view('showUsers-course', [
            'numberPassedCourseExamsByUsers' => $numberPassedCourseExamsByUsers,
            'numberCourseExams' => $numberCourseExams,
            'percentPassedCourseExams' => $percentPassedCourseExams,
            'users' => $users,
            'averageMark' => $averageMark,
        ]);
    }
}
