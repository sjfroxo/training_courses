<?php

namespace App\Repositories;

use App\Models\UserCourse;
use App\Repositories\Interfaces\UserCourseRepositoryInterface as RepositoryInterface;

class UserCourseRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param UserCourse $model
	 *
	 * @return void
	 */
	public function __construct(UserCourse $model)
	{
		parent::__construct($model);
	}

	/**
	 * @param string $course_id
	 * @param string $user_id
	 *
	 * @return string
	 */
	public function getProgress(string $course_id, string $user_id): string
	{
		$progress = $this->getBuilder()->firstWhere([
			['course_id', '=', $course_id],
			['user_id', '=', $user_id]
		]);

		if(auth()->user()->isAdministrator() && $progress == null) {
			return "0";
		}

		return $progress->progress;
	}
}
