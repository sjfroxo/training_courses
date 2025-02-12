<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'user',
            'curator',
            'admin',
        ];

        foreach ($arr as $item) {
            UserRole::factory()->create([
                'title' => $item
            ]);
        }
    }
};
