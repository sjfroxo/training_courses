<?php

namespace App\Policies;

use App\Models\ModuleExamQuestion;
use App\Models\User;

class ModuleExamQuestionPolicy
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
	 * @param ModuleExamQuestion $moduleExamQuestion
	 *
	 * @return bool
	 */
	public function update(User $user, ModuleExamQuestion $moduleExamQuestion): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamQuestion $moduleExamQuestion
	 *
	 * @return bool
	 */
	public function delete(User $user, ModuleExamQuestion $moduleExamQuestion): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamQuestion $moduleExamQuestion
	 *
	 * @return bool
	 */
	public function restore(User $user, ModuleExamQuestion $moduleExamQuestion): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExamQuestion $moduleExamQuestion
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, ModuleExamQuestion $moduleExamQuestion): bool
	{
		return $user->isAdministrator();
	}
}
