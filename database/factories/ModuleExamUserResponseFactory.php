<?php

namespace Database\Factories;

use App\Models\ModuleExamAnswer;
use App\Models\ModuleExamQuestion;
use App\Models\ModuleExamUserResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleExamUserResponse>
 */
class ModuleExamUserResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_exam_question_id' => ModuleExamQuestion::query()->inRandomOrder()->first() ?? ModuleExamQuestion::factory(),
            'user_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
            'module_exam_answer_id' => ModuleExamAnswer::query()->inRandomOrder()->first() ?? ModuleExamAnswer::factory(),
            'text' => fake()->text(),
        ];
    }
}
