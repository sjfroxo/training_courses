<?php

namespace App\Repositories\Interfaces;

use App\Models\Chat;
use Illuminate\Pagination\LengthAwarePaginator;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ChatRepositoryInterface extends AbstractRepositoryInterface
{
	/**
	 * @param Chat $chat
	 * @param string|null $lastMessId
	 *
	 * @return LengthAwarePaginator
	 */
	public function getMessages(Chat $chat, ?string $lastMessId = null): LengthAwarePaginator;

	/**
	 * @param Chat $chat
	 *
	 * @return array
	 */
	public function getReplies(Chat $chat): array;

	/**
	 * @param Chat $chat
	 *
	 * @return array
	 */
	public function getMedia(Chat $chat): array;

	/**
	 * @param $id
	 * @param $extension
	 *
	 * @return string
	 */
	public function getFilesByExtension($id, $extension): string;
}
