<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminEnrollment>
 */
class AdminEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => Admin::all()->random()->id,
            'enrollment_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'start_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'is_notified' => fake()->boolean(),
            'suspension_start_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'suspension_end_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'suspension_reason' => fake()->sentence(),
            'withdrawal_date' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
            'withdrawal_reason' => fake()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,       
        ];
    }
}
