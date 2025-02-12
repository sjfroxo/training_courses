<?php

namespace App\Services;

use App\Contracts\ModelDTO;
use App\Repositories\ChatMessageRepository;
use Illuminate\Database\Eloquent\Model;

class ChatMessageService extends CoreService
{
	/**
	 * @param ChatMessageRepository $repository
	 */
	public function __construct(ChatMessageRepository $repository)
	{
		parent::__construct($repository);
	}

	/**
	 * @param ModelDTO $dto
	 *
	 * @return Model
	 */
	public function create(ModelDTO $dto): Model
	{
		$message = parent::create($dto);

		if($dto->media_file != null) {
			$message->media_url = $this->repository->loadMedia($message->id, $dto->media_file);
		}

		return $message;
	}
}
