<?php

namespace Database\Factories;

use App\Models\ExamUserResult;
use App\Models\ModuleExam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamUserResult>
 */
class ExamUserResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
            'module_exam_id' => ModuleExam::query()->inRandomOrder()->first() ?? ModuleExam::factory(),
            'mark' => fake()->numberBetween(0,10),
        ];
    }
}
