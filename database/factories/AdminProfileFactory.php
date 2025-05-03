<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminProfile>
 */
class AdminProfileFactory extends Factory
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
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'lastname_kana' => fake()->lastName(),
            'firstname_kana' => fake()->firstName(),
            'admin_photo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'birth' => fake()->dateTimeBetween('1950-01-01', '2007-12-31'),
            'gender' => fake()->randomElement(['男性', '女性', 'その他']),
            'blood' => fake()->randomElement(['A型', 'B型', 'O型', 'AB型', '不明', '未回答']),
            'mobile_number' => fake()->phoneNumber(),
            'admin_no' => fake()->numberBetween(10000, 99999),
            'serial_no' => fake()->numberBetween(10000, 99999),
            'website' => fake()->url(),
            'facebook' => fake()->url(),
            'twitter' => fake()->url(),
            'instagram' => fake()->url(),
            'youtube' => fake()->url(),
            'line' => fake()->url(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
