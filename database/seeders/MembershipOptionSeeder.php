<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('membership_options')->insert(
            [
                [
                    'name' => '会員',
                    'description' => '基本的な会員プランです。',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'name' => '非会員',
                    'description' => '非会員プランです。',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'name' => '仮会員',
                    'description' => '仮会員プランです。',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
            ]
        );
    }
}
