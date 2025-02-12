<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
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
	public function viewAny(User $user): bool
	{
		return true;
	}

	/**
	 * @param User $user
	 * @param Course $course
	 *
	 * @return bool
	 */
	public function view(User $user, Course $course): bool
	{
		return $user->courses->contains('id', $course->id);
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
	 * @param Course $course
	 *
	 * @return bool
	 */
	public function update(User $user, Course $course): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Course $course
	 *
	 * @return bool
	 */
	public function delete(User $user, Course $course): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Course $course
	 *
	 * @return bool
	 */
	public function restore(User $user, Course $course): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Course $course
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, Course $course): bool
	{
		return $user->isAdministrator();
	}
}
