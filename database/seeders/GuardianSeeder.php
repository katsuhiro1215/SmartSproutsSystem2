<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guardians')->insert([
            [
                'lastname' => '栫',
                'firstname' => '勝宏',
                'lastname_kana' => 'カコイ',
                'firstname_kana' => 'カツヒロ',
                'relationship' => '父',
                'guardian_photo_path' => null,
                'birth' => '1981-12-15',
                'gender' => '男性',
                'blood' => 'A型',
                'mobile_number' => '09095809257',
                'company_name' => '株式会社カコイ',
                'company_phone_number' => '03-1234-5678',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ]);
    }
}
