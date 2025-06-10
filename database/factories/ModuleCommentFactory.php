<?php

namespace Database\Factories;

use App\Models\ModuleComment;
use App\Models\ModuleExamTheory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleComment>
 */
class ModuleCommentFactory extends Factory
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
            'module_id' => ModuleExamTheory::query()->inRandomOrder()->first() ?? ModuleExamTheory::factory(),
            'text' => fake()->text(),
        ];
    }
}
