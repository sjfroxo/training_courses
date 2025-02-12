<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\Chat;
use App\Models\ChatUser;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
	/**
	 * @return void
	 */
	public function run(): void
	{
		foreach(Chat::all() as $chat) {
			ChatUser::factory(1)->create([
				'chat_id' => $chat->id,
				'user_role' => 'moderator',
			]);
		}

		ChatUser::factory(30)->create(
			['user_role' => 'user']
		);
	}
};
