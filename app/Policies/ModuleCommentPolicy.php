<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\ModuleComment;
use App\Models\User;

class ModuleCommentPolicy
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
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, ModuleComment $moduleComment): bool
	{
		return $user->id === $moduleComment->user_id;
	}

	/**
	 * @param User $user
	 * @param string $id
	 *
	 * @return bool
	 */
	public function create(User $user, string $id): bool
	{
		$course = Module::find($id)->course;

		return $user->courses->contains($course);
	}

	/**
	 * @param User $user
	 * @param ModuleComment $moduleComment
	 *
	 * @return bool
	 */
	public function update(User $user, ModuleComment $moduleComment): bool
	{
		return $user->id === $moduleComment->user_id;
	}

	/**
	 * @param User $user
	 * @param ModuleComment $moduleComment
	 *
	 * @return bool
	 */
	public function delete(User $user, ModuleComment $moduleComment): bool
	{
		return $user->id === $moduleComment->user_id;
	}

	/**
	 * @param User $user
	 * @param ModuleComment $moduleComment
	 *
	 * @return bool
	 */
	public function restore(User $user, ModuleComment $moduleComment): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param ModuleComment $moduleComment
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, ModuleComment $moduleComment): bool
	{
		return $user->isAdministrator();
	}
}
