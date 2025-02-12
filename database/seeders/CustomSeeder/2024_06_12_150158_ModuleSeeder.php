<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\Module;
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
        Module::factory(300)->create();
    }
};
