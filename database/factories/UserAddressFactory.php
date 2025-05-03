<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
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
            'postalcode' => fake()->postcode(),
            'prefecture' => fake()->prefecture(),
            'city' => fake()->city(),
            'address1' => fake()->streetAddress(),
            'address2' => fake()->secondaryAddress(),
            'phone_number' => fake()->phoneNumber(),
            'is_default' => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
