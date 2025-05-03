<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentEnrollment>
 */
class StudentEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::all()->random()->id,
            'application_date' => fake()->dateTimeBetween('2023-05-01', '2025-04-30'),
            'enrollment_date' => fake()->dateTimeBetween('2023-05-01', '2025-04-30'),
            'selected_days' => fake()->randomElement(['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日']),
            'preferred_days' => fake()->randomElement(['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日']),
            'status' => fake()->randomElement(['承認', '保留', '不承認']),
            'is_paid' => fake()->boolean(),
            'is_notified' => fake()->boolean(),
            'cancel_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'suspension_start_date' => fake()->dateTimeBetween('2023-05-01', '2025-04-30'),
            'suspension_end_date' => fake()->dateTimeBetween('2023-05-01', '2025-04-30'),
            'suspension_reason' => fake()->sentence(),
            'withdrawal_date' => fake()->dateTimeBetween('2023-05-01', '2025-04-30'),
            'withdrawal_reason' => fake()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
