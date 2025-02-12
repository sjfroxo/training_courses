<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\UserCourse;
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
        UserCourse::factory(20)->create();
    }
};
