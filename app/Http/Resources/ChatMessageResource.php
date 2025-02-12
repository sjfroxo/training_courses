<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'message' => $this->message,
			'user_id' => $this->user_id,
			'chat_id' => $this->chat_id,
			'type' => $this->type,
			'reply_message_id' => $this->reply_message_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'media_url' => $this->media_url
		];
	}
}
