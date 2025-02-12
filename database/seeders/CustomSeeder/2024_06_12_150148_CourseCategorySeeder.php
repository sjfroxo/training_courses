<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\CourseCategory;
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
        CourseCategory::factory(20)->create();
    }
};
