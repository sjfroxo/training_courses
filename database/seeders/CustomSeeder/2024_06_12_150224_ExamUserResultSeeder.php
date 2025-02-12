<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\ExamUserResult;
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
        ExamUserResult::factory(70)->create();
    }
};
