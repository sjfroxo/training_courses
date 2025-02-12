<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCourse;

class UserCoursePolicy
{
	/**
	 * @param User $user
	 * @param string $ability
	 *
	 * @return bool|null
	 */
	public function before(User $user, string $ability): bool|null
	{
		if($user->isAdministrator()) {
			return true;
		}

		return null;
	}

	/**
	 * @param User $user
	 *
	 * @return bool
	 */
	public function create(User $user): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param UserCourse $userCourse
	 *
	 * @return bool
	 */
	public function delete(User $user, UserCourse $userCourse): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param UserCourse $userCourse
	 *
	 * @return bool
	 */
	public function restore(User $user, UserCourse $userCourse): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param UserCourse $userCourse
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, UserCourse $userCourse): bool
	{
		return $user->isAdministrator();
	}
}
