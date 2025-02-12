<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var object
	 */
	protected object $message;
	/**
	 * @var string|null
	 */
	protected ?string $media_url;

	/**
	 * @param Model $chatMessage
	 */
	public function __construct(Model $chatMessage)
	{
		$this->message = $chatMessage;

		$this->media_url = $this->message->media_url;
	}

	/**
	 * @return string
	 */
	public function broadcastAs(): string
	{
		return 'chat-message.sent';
	}

	/**
	 * @return array
	 */
	public function broadCastWith(): array
	{
		return [
			'message' => $this->message->message,
			'user_id' => $this->message->user_id,
			'chat_id' => $this->message->chat_id,
			'reply_message_id' => $this->message->reply_message_id,
			'id' => $this->message->id,
			'type' => $this->message->type,
			'media_url' => $this->media_url,
		];
	}

	/**
	 * @return Channel[]
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('chat.' . $this->message->chat_id),
		];
	}
}
