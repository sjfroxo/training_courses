<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleExamUserResponse;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ModuleExamUserResponse::factory(60)->create();
    }
};
