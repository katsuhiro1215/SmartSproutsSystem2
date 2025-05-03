<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_enrollments')->insert(
            [
                [
                    'admin_id' => 1,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 2,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 3,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 4,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 5,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 6,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 7,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'admin_id' => 8,
                    'enrollment_date' => '2024-06-01',
                    'start_date' => '2024-06-01',
                    'is_notified' => 0,
                    'suspension_start_date' => null,
                    'suspension_end_date' => null,
                    'suspension_reason' => null,
                    'withdrawal_date' => null,
                    'withdrawal_reason' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
            ],
        );
    }
}
