<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ModuleComment;
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
        ModuleComment::factory(50)->create();
    }
};
