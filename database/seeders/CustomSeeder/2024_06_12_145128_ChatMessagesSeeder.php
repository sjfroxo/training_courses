<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ChatMessage;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		ChatMessage::factory(100)->create(
			['type' => 'text'],
		);
	}
};
