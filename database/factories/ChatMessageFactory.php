<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatMessageFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string>
	 */
	public function definition(): array
	{
		$chat = Chat::query()->inRandomOrder()->first() ?? Chat::factory();

		$user_ids = [];

		foreach($chat->users as $user) {
			$user_ids[] = $user->id;
		}

		return [
			'chat_id' => $chat,
			'user_id' => User::query()->firstWhere('id', '=', $user_ids[rand(0, count($user_ids) - 1)]),
			'type' => fake()->text(10),
			'reply_message_id' => null,
			'message' => fake()->text(255),
		];
	}
}
