<?php

namespace App\Services;

use App\Repositories\UserCourseRepository;

class UserCourseService extends CoreService
{
	/**
	 * @param UserCourseRepository $repository
	 */
	public function __construct(UserCourseRepository $repository)
	{
		parent::__construct($repository);
	}

	/**
	 * @param string $course_id
	 * @param string $user_id
	 *
	 * @return string
	 */
	public function getProgress(string $course_id, string $user_id): string
	{
		return $this->repository->getProgress($course_id, $user_id);
	}
}
