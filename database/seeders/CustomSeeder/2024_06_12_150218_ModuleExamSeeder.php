<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleExamTheory;
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
        ModuleExamTheory::factory(20)->create();
    }
};
