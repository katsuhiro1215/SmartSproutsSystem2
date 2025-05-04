<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'membership_option_id' => fake()->numberBetween(1, 3),
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'lastname_kana' => fake()->lastName(),
            'firstname_kana' => fake()->firstName(),
            'student_photo_path' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            'birth' => fake()->dateTimeBetween('1980-01-01', '2022-12-31'),
            'gender' => fake()->randomElement(['男性', '女性', 'その他']),
            'blood' => fake()->randomElement(['A型', 'B型', 'O型', 'AB型', '不明', '未回答']),
            'mobile_number' => fake()->phoneNumber(),
            'mobile_number_relationship' => fake()->randomElement(['父', '母', '兄', '姉']),
            'personal_history' => fake()->text(),
            'member_no' => fake()->numberBetween(10000, 99999),
            'serial_no' => fake()->numberBetween(10000, 99999),
            'permission_photo' => fake()->boolean(),
            'permission_dm' => fake()->boolean(),
            'remarks' => fake()->text(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
