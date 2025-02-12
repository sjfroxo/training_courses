<?php

namespace App\Services;

use App\Repositories\UserRoleRepository;

class UserRoleService extends CoreService
{
	/**
	 * @param UserRoleRepository $repository
	 */
	public function __construct(UserRoleRepository $repository)
	{
		parent::__construct($repository);
	}
}
