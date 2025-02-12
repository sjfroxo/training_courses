<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\User;

class ModulePolicy
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
	 * @param Module $module
	 *
	 * @return bool
	 */
	public function view(User $user, Module $module): bool
	{
		$userModules = $user->courses->pluck('modules')->flatten();

		return $userModules->contains('id', $module->id);
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
	 * @param Module $module
	 *
	 * @return bool
	 */
	public function update(User $user, Module $module): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Module $module
	 *
	 * @return bool
	 */
	public function delete(User $user, Module $module): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Module $module
	 *
	 * @return bool
	 */
	public function restore(User $user, Module $module): bool
	{
		return $user->isAdministrator();
	}

	/**
	 * @param User $user
	 * @param Module $module
	 *
	 * @return bool
	 */
	public function forceDelete(User $user, Module $module): bool
	{
		return $user->isAdministrator();
	}
}
