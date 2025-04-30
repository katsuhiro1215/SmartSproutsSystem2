<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'store_id' => 1,
                'name' => '体操教室',
                'description' => '会員制の体操教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2023-05-01',
                'end_date' => null,
            ],
            [
                'store_id' => 2,
                'name' => 'ヨガ教室',
                'description' => '会員制のヨガ教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-09-01',
                'end_date' => null,
            ],
            [
                'store_id' => 2,
                'name' => 'ピラティス教室',
                'description' => '会員制のピラティス教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-10-01',
                'end_date' => null,
            ],
            [
                'store_id' => 3,
                'name' => 'プログラミング教室',
                'description' => '会員制のプログラミング教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 3,
                'name' => 'ゲーミング教室',
                'description' => '会員制のゲーミング教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 4,
                'name' => 'ピアノ教室',
                'description' => '会員制のピアノ教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 4,
                'name' => 'バイオリン教室',
                'description' => '会員制のバイオリン教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 4,
                'name' => 'ギター教室',
                'description' => '会員制のギター教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 4,
                'name' => 'ドラム教室',
                'description' => '会員制のドラム教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => '2024-11-01',
                'end_date' => null,
            ],
            [
                'store_id' => 4,
                'name' => 'ボーカル教室',
                'description' => '会員制のボーカル教室です。',
                'lesson_photo_path' => null,
                'status' => 1,
                'start_date' => null,
                'end_date' => null,
            ],
        ]);
    }
}
