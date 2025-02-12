<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\User;
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
        User::factory(20)->create();
    }
};
