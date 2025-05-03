<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'lastname_kana' => fake()->lastKanaName(),
            'firstname_kana' => fake()->firstKanaName(),
            'relationship' => fake()->randomElement(['父', '母', '兄', '姉']),
            'guardian_photo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'birth' => fake()->dateTimeBetween('1950-01-01', '2007-12-31'),
            'blood' => fake()->randomElement(['A型', 'B型', 'O型', 'AB型', '不明', '未回答']),
            'mobile_number' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'company_phone_number' => fake()->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
