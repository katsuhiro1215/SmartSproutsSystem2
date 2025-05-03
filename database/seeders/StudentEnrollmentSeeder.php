<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('student_enrollments')->insert([
            [
                'student_id' => 1,
                'application_date' => '2023-01-01',
                'enrollment_date' => '2023-04-01',
                'selected_days' => '月曜日, 水曜日',
                'preferred_days' => '月曜日',
                'status' => '在籍',
                'is_paid' => true,
                'is_notified' => false,
                'cancel_date' => null,
                'suspension_start_date' => null,
                'suspension_end_date' => null,
                'suspension_reason' => null,
                'withdrawal_date' => null,
                'withdrawal_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
