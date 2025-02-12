<?php

namespace Database\Factories;

use App\Models\ModuleExam;
use App\Models\ModuleExamQuestion;
use App\Models\QuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleExamQuestion>
 */
class ModuleExamQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'module_exam_id' => ModuleExam::query()->inRandomOrder()->first() ?? ModuleExam::factory(),
            'question_type_id' => QuestionType::query()->inRandomOrder()->first() ?? QuestionType::factory(),
        ];
    }
}
