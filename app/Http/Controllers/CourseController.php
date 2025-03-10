<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CourseDTO;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseService;
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
     */
	public function __construct(
		protected CourseService $service,
		protected UserCourseService $userCourseService,
	)
    {}

	/**
	 * @return View
	 * @throws AuthorizationException
	 */
	public function index(): View
	{
		$this->authorize('viewAny', Course::class);

		$courses = $this->service->paginate(4);

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

        $dto = new CourseDTO(
            (string)$request->validated()['title'],
            (string)$request->validated()['description'],
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

        $dto = new CourseDTO(
            (string)$request->validated()['title'],
            (string)$request->validated()['description'],
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

		$averageMark = $this->service->calculateAverageMark($slug);

		$percentPassedCourseExams = $this->service->calculatePercentPassedCourseExams($numberCourseExams, $numberPassedCourseExamsByUsers);

		return view('showUsers-course', [
            'numberPassedCourseExamsByUsers' => $numberPassedCourseExamsByUsers,
            'numberCourseExams' => $numberCourseExams,
            'percentPassedCourseExams' => $percentPassedCourseExams,
            'users' => $users,
            'averageMark' => $averageMark,
        ]);
	}

//    /**
//     * @param string $section
//     * @return View
//     * @throws AuthorizationException
//     */
//    public function userStudy(string $section): View
//    {
//        $course = $this->service->findBySlug('default-slug');
//        $progress = $this->userCourseService->getProgress();
//
//        $this->authorize('view', $course);
//
//        return view('user-study', [
//            'section' => $section,
//            'course' => $course,
//            'progress' => $progress,
//        ]);
//    }
}
