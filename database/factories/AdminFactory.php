<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'role' => $this->generateRole(),
            'remember_token' => fake()->uuid(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

    /**
     * Generate a role with specific probabilities.
     *
     * @return string
     */
    private function generateRole(): string
    {
        $random = fake()->numberBetween(1, 10); // 1〜10のランダムな数値を生成

        if ($random === 1) {
            return 'Manager'; // 1割 (10%)
        } elseif ($random <= 4) {
            return 'Employee'; // 3割 (30%)
        } else {
            return 'Instructor'; // 6割 (60%)
        }
    }
}
