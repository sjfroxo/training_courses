<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleExamAnswer;
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
        ModuleExamAnswer::factory(300)->create();
    }
};
