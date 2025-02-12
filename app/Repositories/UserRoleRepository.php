<?php

namespace App\Repositories;

use App\Models\UserRole;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;

class UserRoleRepository extends CoreRepository implements UserRoleRepositoryInterface
{
	/**
	 * @param UserRole $model
	 *
	 * @return void
	 */
	public function __construct(UserRole $model)
	{
		parent::__construct($model);
	}
}
