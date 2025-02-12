<?php

namespace App\Repositories;

use App\Models\ChatUser;
use App\Repositories\Interfaces\ChatUserRepositoryInterface;

class ChatUserRepository extends CoreRepository implements ChatUserRepositoryInterface
{
	/**
	 * @param ChatUser $model
	 */
	public function __construct(ChatUser $model)
	{
		parent::__construct($model);
	}
}
