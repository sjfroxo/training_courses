<?php

namespace App\Policies;

use App\Models\ModuleExam;
use App\Models\User;

class ModuleExamPolicy
{
	/**
	 * @param User $user
	 *
	 * @return bool
	 */
	public function viewAny(User $user): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function view(User $user, ModuleExam $moduleExam): bool
	{
		if($user->isAdministrator())
			return true;

		$userModuleExamAnswers = $user->moduleExamAnswers;

		foreach($userModuleExamAnswers as $answer) {
			if($answer->moduleExamQuestion->moduleExam->id === $moduleExam->id) {
				return false;
			}
		}

		return true;
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
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function update(User $user, ModuleExam $moduleExam): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function delete(User $user, ModuleExam $moduleExam): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function restore(User $user, ModuleExam $moduleExam): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, ModuleExam $moduleExam): bool
	{
		return $user->isAdministrator();
	}
}
