<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'chat_messages';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'message',
		'user_id',
		'chat_id',
		'type',
		'reply_message_id'
	];

	/**
	 * @return BelongsTo
	 */
	public function chat(): BelongsTo
	{
		return $this->belongsTo(Chat::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return string
	 */
	public function replyMessage(): string
	{
		$message = ChatMessage::query()->where("id", "=", $this->reply_message_id)->get()[0];

		if($message->type == "voice") {
			return "voice message";
		} else if($message->type == "video") {
			return "video message";
		} else {
			return $message->message;
		}
	}
}
