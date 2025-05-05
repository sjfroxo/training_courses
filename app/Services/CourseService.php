<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class CourseService extends CoreService
{
	use AuthorizesRequests;

	/**
	 * @param CourseRepository $repository
	 *
	 * @return void
	 */
	public function __construct(CourseRepository $repository)
	{
		parent::__construct($repository);
	}

	/**
	 * @param $slug
	 *
	 * @return int
	 */
	public function countCourseExams($slug): int
	{
		$course = $this->repository->findBySlug($slug);
		$numberCourseTests = 0;
		foreach($course->modules as $module) {
			$numberCourseTests += $module->moduleExams->count();
		}

		return $numberCourseTests;
	}

	/**
	 * @param string $slug
	 *
	 * @return array Ключ - ID юзера. Значение - Кол-во пройденных тестов
	 *
	 */
	public function countPassedCourseExamsByUsers(string $slug): array
	{
		$course = $this->repository->findBySlug($slug);
		$users = $course->users;

		$courseModuleExamIds = $course->modules->flatMap(function($module) {
			return $module->moduleExams->pluck('id');
		})->toArray();

		$userCounts = [];

		foreach($users as $user) {
			$userModuleExamIds = $user->moduleExams->pluck('pivot.module_exam_id')->toArray();

			$intersection = array_intersect($userModuleExamIds, $courseModuleExamIds);

			if(!empty($intersection)) {
				$userCounts[$user->id] = count($intersection);
			} else {
				$userCounts[$user->id] = 0;
			}
		}

		return $userCounts;
	}

	/**
	 * @param $numberCourseExams
	 * @param $numberPassedCourseExamsByUsers
	 *
	 * @return array
	 */
	public function calculatePercentPassedCourseExams($numberCourseExams, $numberPassedCourseExamsByUsers): array
	{
		$percentPassedCourseExams = [];

		foreach($numberPassedCourseExamsByUsers as $userId => $passedExams) {
			if($numberCourseExams > 0) {
				$percentPassedCourseExams[$userId] = ($passedExams / $numberCourseExams) * 100;
			} else {
				$percentPassedCourseExams[$userId] = 0;
			}
		}

		return $percentPassedCourseExams;
	}

    /**
     * @param int $courseId
     * @return Course
     */
    public function getUsers(int $courseId): Course
    {
        return $this->repository->getUsers($courseId);
    }
}
