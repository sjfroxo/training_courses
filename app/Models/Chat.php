<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
	use HasFactory, Sluggable;

	/**
	 * @var string
	 */
	protected $table = 'chats';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title'
	];

	/**
	 * @return HasMany
	 */
	public function chatMessages(): HasMany
	{
		return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
	}

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'chat_users', 'chat_id', 'user_id')
			->withPivot('user_role')
			->withTimestamps();
	}

	/**
	 * @return ChatMessage|null
	 */
	public function lastMessage(): ChatMessage|null
	{
		$message = $this->chatMessages()->get()->last();

		if($message->type == "voice") {
			$message->message = "Voice message";
		} else if($message->type == "video") {
			$message->message = "Video message";
		}

		return $message;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title',
			],
		];
	}
}
