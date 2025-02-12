<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseCategory>
 */
class CourseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->first() ?? Category::factory(),
            'course_id' => Course::query()->inRandomOrder()->first() ?? Course::factory(),
        ];
    }
}
