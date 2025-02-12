<?php

namespace App\Policies;

use App\Models\ModuleExamAnswer;
use App\Models\ModuleExanAnswer;
use App\Models\User;

class ModuleExamAnswerPolicy
{
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
	 * @param ModuleExamAnswer $moduleExamAnswer
	 *
	 * @return bool
	 */
	public function update(User $user, ModuleExamAnswer $moduleExamAnswer): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamAnswer $moduleExamAnswer
	 *
	 * @return bool
	 */
	public function delete(User $user, ModuleExamAnswer $moduleExamAnswer): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamAnswer $moduleExamAnswer
	 *
	 * @return bool
	 */
	public function restore(User $user, ModuleExamAnswer $moduleExamAnswer): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamAnswer $moduleExamAnswer
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, ModuleExamAnswer $moduleExamAnswer): bool
	{
		return $user->isAdministrator();
	}
}
