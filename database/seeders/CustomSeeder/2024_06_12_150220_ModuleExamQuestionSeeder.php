<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleExamQuestion;
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
        ModuleExamQuestion::factory(200)->create();
    }
};
