<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Guardian;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuardianUser>
 */
class GuardianUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'guardian_id' => Guardian::all()->random()->id,
        ];
    }
}
