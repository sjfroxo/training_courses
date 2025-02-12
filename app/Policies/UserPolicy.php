<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param User $model
	 *
	 * @return bool
	 */
	public function view(User $user, User $model): bool
	{
		return $user->isAdministrator();
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
	 * @param User $model
	 *
	 * @return bool
	 */
	public function update(User $user, User $model): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param User $model
	 *
	 * @return bool
	 */
	public function delete(User $user, User $model): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param User $model
	 *
	 * @return bool
	 */
	public function restore(User $user, User $model): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param User $model
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, User $model): bool
	{
		return $user->isAdministrator();
	}
}
