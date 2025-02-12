<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ChatMessageRequest;
use Illuminate\Http\UploadedFile;

class ChatMessageDTO implements ModelDTO
{
	/**
	 * @param string $chat_id
	 * @param string $user_id
	 * @param string $type
	 * @param ?string $reply_message_id
	 * @param ?string $message
	 * @param ?UploadedFile $media_file
	 */
	public function __construct(
		public readonly string        $chat_id,
		public readonly string        $user_id,
		public readonly string        $type,
		public readonly ?string       $reply_message_id,
		public readonly ?string       $message,
		public readonly ?UploadedFile $media_file,
	) {}

	/**
	 * @param ChatMessageRequest $request
	 *
	 * @return ChatMessageDTO
	 */
	public static function appRequest(ChatMessageRequest $request): ChatMessageDTO
	{
		return new ChatMessageDTO(
			$request['chat_id'],
			$request['user_id'],
			$request['type'],
			$request['reply_message_id'],
			$request['message'],
			$request['media_file'],
		);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'chat_id' => $this->chat_id,
			'user_id' => $this->user_id,
			'type' => $this->type,
			'reply_message_id' => $this->reply_message_id,
			'message' => $this->message,
			'media_file' => $this->media_file,
		];
	}
}
