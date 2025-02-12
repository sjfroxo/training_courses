<?php

namespace App\Services;

use App\Repositories\CourseRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
	 * @param string $slug
	 *
	 * @return array
	 */
	public function calculateAverageMark(string $slug): array
	{
		$course = $this->repository->findBySlug($slug);
		$users = $course->users;
		$userAverages = [];

		$courseModuleExamIds = $course->modules->flatMap(function($module) {
			return $module->moduleExams->pluck('id');
		})->toArray();

		foreach($users as $user) {
			$userModuleExamIds = $user->moduleExams->pluck('pivot.module_exam_id')->toArray();
			$intersection = array_intersect($userModuleExamIds, $courseModuleExamIds);
			if(!empty($intersection)) {
				$marks = $user->moduleExams
					->whereIn('pivot.module_exam_id', $intersection)
					->pluck('pivot.mark')
					->toArray();
				$averageGrade = array_sum($marks) / count($marks);
				$userAverages[$user->id] = $averageGrade;
			}
		}

		return $userAverages;
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
}
