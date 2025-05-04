<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'membership_option_id' => 1,
                'lastname' => '栫',
                'firstname' => 'ひなた',
                'lastname_kana' => 'カコイ',
                'firstname_kana' => 'ヒナタ',
                'student_photo_path' => null,
                'birth' => '2020-01-01',
                'gender' => '女性',
                'blood' => 'A型',
                'mobile_number' => '090-1234-5678',
                'mobile_number_relationship' => '母',
                'personal_history' => '特になし',
                'member_no' => '123456',
                'serial_no' => 'ABC123456',
                'permission_photo' => true,
                'permission_dm' => true,
                'remarks' => '特になし',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
