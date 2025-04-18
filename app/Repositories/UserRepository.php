<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param User $model
	 */
	public function __construct(User $model)
	{
		parent::__construct($model);
	}

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::all();
    }

	/**
	 * @param User $user
	 *
	 * @return string
	 */
	public function getUserRole(User $user): string
	{
		return $user->role()->first()->title;
	}
}
