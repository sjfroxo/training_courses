<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\Category;
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
        Category::factory(20)->create();
    }
};
