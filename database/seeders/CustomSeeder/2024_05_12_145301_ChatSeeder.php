<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\Chat;
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
        Chat::factory(20)->create();
    }
};
