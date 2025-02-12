<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\ModuleExam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleExam>
 */
class ModuleExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id' => Module::query()->inRandomOrder()->first() ?? Module::factory(),
            'is_autochecked' => fake()->boolean(),
        ];
    }
}
