<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_categories')->insert([
            [
                'lesson_id' => 1,
                'type' => '一般教室',
                'name' => '一般教室',
                'description' => '一般会員向け体操教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'lesson_id' => 1,
                'type' => '体験教室',
                'name' => '無料体験教室',
                'description' => '非会員向け無料体操教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'lesson_id' => 1,
                'type' => '体験教室',
                'name' => '有料体験教室',
                'description' => '非会員向け有料体操教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'lesson_id' => 1,
                'type' => '短期教室',
                'name' => '2023夏の短期教室',
                'description' => '2023年夏の短期教室の説明',
                'course_category_photo_path' => null,
                'status' => false,
                'start_date' => '2023-07-20',
                'end_date' => '2023-08-31',
            ],
            [
                'lesson_id' => 1,
                'type' => '短期教室',
                'name' => '2023冬の短期教室',
                'description' => '2023年冬の短期教室の説明',
                'course_category_photo_path' => null,
                'status' => false,
                'start_date' => '2023-12-20',
                'end_date' => '2025-01-10',
            ],
            [
                'lesson_id' => 1,
                'type' => '短期教室',
                'name' => '2024夏の短期教室',
                'description' => '2024年夏の短期教室の説明',
                'course_category_photo_path' => null,
                'status' => false,
                'start_date' => '2024-07-20',
                'end_date' => '2024-08-31',
            ],
            [
                'lesson_id' => 2,
                'type' => '一般教室',
                'name' => '一般教室',
                'description' => '一般会員向けヨガ教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'lesson_id' => 2,
                'type' => '体験教室',
                'name' => '無料体験教室',
                'description' => '非会員向け無料ヨガ教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'lesson_id' => 2,
                'type' => '体験教室',
                'name' => '有料体験教室',
                'description' => '非会員向け有料ヨガ教室の説明',
                'course_category_photo_path' => null,
                'status' => true,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
        ]);
    }
}
