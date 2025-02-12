<?php

namespace Database\Factories;

use App\Models\ModuleExamAnswer;
use App\Models\ModuleExamQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleExamAnswer>
 */
class ModuleExamAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->text(),
            'module_exam_question_id' => ModuleExamQuestion::query()->inRandomOrder()->first() ?? ModuleExamQuestion::factory(),
            'is_correct' => fake()->boolean(),
        ];
    }
}
