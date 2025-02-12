<?php

namespace App\Policies;

use App\Models\ModuleExam;
use App\Models\ModuleExamUserResponse;
use App\Models\User;

class ModuleExamUserResponsePolicy
{
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
	 * @param ModuleExamUserResponse $moduleExamUserResponse
	 *
	 * @return bool
	 */
	public function view(User $user, ModuleExamUserResponse $moduleExamUserResponse): bool
	{
		return true;
	}

	/**
	 * @param User $user
	 * @param ModuleExam $moduleExam
	 *
	 * @return bool
	 */
	public function create(User $user, ModuleExam $moduleExam): bool
	{
		$userHasAnswers = $user->moduleExamAnswers()
			->whereHas('moduleExamQuestion', function($query) use ($moduleExam) {
				$query->where('module_exam_id', $moduleExam->id);
			})->exists();

		return !$userHasAnswers;
	}

	/**
	 * @param User $user
	 * @param ModuleExamUserResponse $moduleExamUserResponse
	 *
	 * @return bool
	 */
	public function update(User $user, ModuleExamUserResponse $moduleExamUserResponse): bool
	{
		//
	}

	/**
	 * @param User $user
	 * @param ModuleExamUserResponse $moduleExamUserResponse
	 *
	 * @return bool
	 */
	public function delete(User $user, ModuleExamUserResponse $moduleExamUserResponse): bool
	{
		//
	}

	/**
	 * @param User $user
	 * @param ModuleExamUserResponse $moduleExamUserResponse
	 *
	 * @return bool
	 */
	public function restore(User $user, ModuleExamUserResponse $moduleExamUserResponse): bool
	{
		//
	}

	/**
	 * @param User $user
	 * @param ModuleExamUserResponse $moduleExamUserResponse
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, ModuleExamUserResponse $moduleExamUserResponse): bool
	{
		//
	}
}
