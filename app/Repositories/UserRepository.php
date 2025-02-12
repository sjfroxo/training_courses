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
	 * @param string $userId
	 *
	 * @return Collection
	 */
	public function getChats(string $userId): Collection
	{
		$user = $this->model->query()->firstWhere('id', '=', $userId);

		$chats = $user->chats()->get();

		return $this->getLastMessages($chats);
	}

	/**
	 * @param Collection $chats
	 *
	 * @return Collection
	 */
	public function getLastMessages(Collection $chats): Collection
	{
		foreach($chats as $chat) {
			$chat->lastMessage = $chat->lastMessage();
		}

		return $chats;
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
