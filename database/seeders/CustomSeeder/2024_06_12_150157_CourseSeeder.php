<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\Course;
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
        Course::factory(100)->create();
    }
};
