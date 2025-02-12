<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleExam;
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
        ModuleExam::factory(20)->create();
    }
};
