<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => 2, // デフォルトの組織ID
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement(['大阪支店', '名古屋支店', '札幌支店', '福岡支店']),
            'code' => $this->faker->unique()->randomNumber(5),
            'theme_color' => $this->faker->hexColor,
            'description' => $this->faker->text(100),
            'email' => $this->faker->unique()->safeEmail,
            'store_photo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'store_logo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'postalcode' => $this->faker->postcode,
            'prefecture' => fake()->prefecture(),
            'city' => fake()->city(),
            'address1' => fake()->streetAddress(),
            'address2' => fake()->secondaryAddress(),
            'phone_number' => fake()->phoneNumber(),
            'fax_number' => fake()->phoneNumber(),
            'status' => $this->faker->boolean,
            'established_date' => fake()->dateTimeBetween('2024-05-01', '2025-04-30'),
            'website' => $this->faker->url,
            'facebook' => $this->faker->url,
            'twitter' => $this->faker->url,
            'instagram' => $this->faker->url,
            'youtube' => $this->faker->url,
            'line' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
