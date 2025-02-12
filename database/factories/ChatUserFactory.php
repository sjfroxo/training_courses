<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatUserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'chat_id' => Chat::query()->inRandomOrder()->first() ?? Chat::factory(),
			'user_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
			'user_role' => 'user',
		];
	}
}
