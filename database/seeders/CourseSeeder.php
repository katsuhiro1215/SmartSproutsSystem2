<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert(
            [
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => 'コース',
                    'description' => '体操の基礎を学ぶコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                ],
                [
                    'lesson_id' => 2,
                    'course_category_id' => 2,
                    'name' => 'ヨガコース',
                    'description' => 'リラックスと柔軟性を高めるコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-09-01',
                    'end_date' => null,
                ],
                [
                    'lesson_id' => 3,
                    'course_category_id' => 3,
                    'name' => 'ピラティスコース',
                    'description' => '体幹を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                ],
            ]
        );
    }
}
