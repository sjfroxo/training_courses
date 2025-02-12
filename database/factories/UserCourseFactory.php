<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserCourse>
 */
class UserCourseFactory extends Factory
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
            'course_id' => Course::query()->inRandomOrder()->first() ?? Course::factory(),
            'progress' => fake()->numberBetween(0,10),
        ];
    }
}
