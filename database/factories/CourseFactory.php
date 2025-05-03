<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::all()->random()->id,
            'course_category_id' => CourseCategory::all()->random()->id,
            'name' => $this->faker->name(),
            'description' => $this->faker->text(100),
            'course_photo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'status' => $this->faker->boolean,
            'start_date' => $this->faker->dateTimeBetween('2024-05-01', '2025-04-30'),
            'end_date' => $this->faker->dateTimeBetween('2024-05-01', '2025-04-30'),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
