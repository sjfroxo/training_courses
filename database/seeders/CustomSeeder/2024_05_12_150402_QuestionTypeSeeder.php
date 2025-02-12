<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\QuestionType;
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
        $arr = [
            'text',
            'multiple choice',
            'single choice',
        ];

        foreach ($arr as $item) {
            QuestionType::factory()->create([
                'title' => $item
            ]);
        }
    }
};
