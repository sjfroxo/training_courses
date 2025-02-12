<?php

namespace App\Services;

use App\Repositories\ChatUserRepository;

class ChatUserService extends CoreService
{
	/**
	 * @param ChatUserRepository $repository
	 */
	public function __construct(ChatUserRepository $repository)
	{
		parent::__construct($repository);
	}
}
