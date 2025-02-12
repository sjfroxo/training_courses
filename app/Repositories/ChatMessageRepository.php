<?php

namespace App\Repositories;

use App\Models\ChatMessage;
use App\Repositories\Interfaces\ChatMessageRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChatMessageRepository extends CoreRepository implements ChatMessageRepositoryInterface
{
	/**
	 * @param ChatMessage $model
	 */
	public function __construct(ChatMessage $model)
	{
		parent::__construct($model);
	}

	/**
	 * @param string $id
	 * @param UploadedFile $file
	 *
	 * @return string
	 */
	public function loadMedia(string $id, UploadedFile $file): string
	{
		$path = 'public/messages/' . $id;

		$loadedFile = Storage::put($path, $file);

		return Storage::url($loadedFile);
	}
}
