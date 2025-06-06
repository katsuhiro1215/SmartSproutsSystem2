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
                    'name' => '年少・年中コース',
                    'description' => '幼稚園の年少・年中が対象のコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => '年長・1年生コース',
                    'description' => '幼稚園の年長、小学生の1年生が対象のコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => '2年・3年生コース',
                    'description' => '小学生の2年生・3年生が対象のコースです。',
                    'course_photo_path' => null,
                    'status' => false,
                    'start_date' => '2023-05-01',
                    'end_date' => '2024-03-31',
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => '2024-04-01',
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => '小学生コース',
                    'description' => '小学生のみが対象のコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => '小学・中学生コース',
                    'description' => '小学生の4年生から中学生が対象のコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => 'キッズアクロコース',
                    'description' => '幼稚園の年中から、小学生の3年生までを対象としたアクロバットコースです。アクロバットクラスはお申込条件として、「壁に倒立ができる」「側転」「ブリッジができる」お子様を対象とさせていただきます。主に、マット運動での技の習得を目指します。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => 'アクロバットコース',
                    'description' => '小学生の4年生から中学生が対象としたアクロバットコースです。アクロバットクラスはお申込条件として、「壁に倒立ができる」「側転」「ブリッジができる」お子様を対象とさせていただきます。主に、マット運動での技の習得を目指します。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2023-05-01',
                    'end_date' => null,
                    'created_at' => '2023-04-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 1,
                    'course_category_id' => 1,
                    'name' => '親子体操コース',
                    'description' => '親子で楽しむ体操コースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-04-01',
                    'end_date' => null,
                    'created_at' => '2024-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 2,
                    'course_category_id' => 13,
                    'name' => 'ヨガコース',
                    'description' => 'リラックスと柔軟性を高めるコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-09-01',
                    'end_date' => null,
                    'created_at' => '2024-08-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 2,
                    'course_category_id' => 14,
                    'name' => 'ヨガコース',
                    'description' => 'リラックスと柔軟性を高めるコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-09-01',
                    'end_date' => null,
                    'created_at' => '2024-08-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 2,
                    'course_category_id' => 15,
                    'name' => 'ヨガコース',
                    'description' => 'リラックスと柔軟性を高めるコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-09-01',
                    'end_date' => null,
                    'created_at' => '2024-08-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 3,
                    'course_category_id' => 16,
                    'name' => 'ピラティスコース',
                    'description' => '体幹を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 3,
                    'course_category_id' => 17,
                    'name' => 'ピラティスコース',
                    'description' => '体幹を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 3,
                    'course_category_id' => 18,
                    'name' => 'ピラティスコース',
                    'description' => '体幹を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 4,
                    'course_category_id' => 19,
                    'name' => 'Web基礎プログラミングコース',
                    'description' => 'HTML/CSS/JavaScriptを学ぶコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 4,
                    'course_category_id' => 20,
                    'name' => 'Web基礎プログラミングコース',
                    'description' => 'HTML/CSS/JavaScriptを学ぶコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 4,
                    'course_category_id' => 21,
                    'name' => 'Web基礎プログラミングコース',
                    'description' => 'HTML/CSS/JavaScriptを学ぶコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 5,
                    'course_category_id' => 22,
                    'name' => 'ゲーミングコース',
                    'description' => 'ゲームを楽しむためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 5,
                    'course_category_id' => 23,
                    'name' => 'ゲーミングコース',
                    'description' => 'ゲームを楽しむためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 5,
                    'course_category_id' => 24,
                    'name' => 'ゲーミングコース',
                    'description' => 'ゲームを楽しむためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 6,
                    'course_category_id' => 25,
                    'name' => 'ピアノコース',
                    'description' => 'ピアノを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 6,
                    'course_category_id' => 26,
                    'name' => 'ピアノコース',
                    'description' => 'ピアノを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 6,
                    'course_category_id' => 27,
                    'name' => 'ピアノコース',
                    'description' => 'ピアノを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 7,
                    'course_category_id' => 28,
                    'name' => 'バイオリンコース',
                    'description' => 'バイオリンを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 7,
                    'course_category_id' => 29,
                    'name' => 'バイオリンコース',
                    'description' => ' バイオリンを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 7,
                    'course_category_id' => 30,
                    'name' => 'バイオリンコース',
                    'description' => 'バイオリンを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 8,
                    'course_category_id' => 31,
                    'name' => 'ギターコース',
                    'description' => 'ギターを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 8,
                    'course_category_id' => 32,
                    'name' => 'ギターコース',
                    'description' => 'ギターを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 8,
                    'course_category_id' => 33,
                    'name' => 'ギターコース',
                    'description' => 'ギターを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 9,
                    'course_category_id' => 34,
                    'name' => 'ドラムコース',
                    'description' => 'ドラムを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 9,
                    'course_category_id' => 35,
                    'name' => 'ドラムコース',
                    'description' => 'ドラムを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 9,
                    'course_category_id' => 36,
                    'name' => 'ドラムコース',
                    'description' => 'ドラムを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 10,
                    'course_category_id' => 37,
                    'name' => 'ボーカルコース',
                    'description' => 'ボーカルを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 10,
                    'course_category_id' => 38,
                    'name' => 'ボーカルコース',
                    'description' => 'ボーカルを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 10,
                    'course_category_id' => 39,
                    'name' => 'ボーカルコース',
                    'description' => 'ボーカルを学ぶためのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2024-10-01',
                    'end_date' => null,
                    'created_at' => '2024-09-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 40,
                    'name' => '親子コース',
                    'description' => '親子を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 40,
                    'name' => '幼児コース',
                    'description' => '幼児を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 40,
                    'name' => '小学生コース',
                    'description' => '小学生を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 40,
                    'name' => '中学生コース',
                    'description' => '中学生を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 40,
                    'name' => '選手・育成コース',
                    'description' => '選手・育成を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => false,
                    'start_date' => '2025-10-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 41,
                    'name' => '親子コース',
                    'description' => '親子を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 41,
                    'name' => '幼児コース',
                    'description' => '幼児を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 41,
                    'name' => '小学生コース',
                    'description' => '小学生を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 42,
                    'name' => '親子コース',
                    'description' => '親子を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 42,
                    'name' => '幼児コース',
                    'description' => '幼児を対象としたコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
                [
                    'lesson_id' => 11,
                    'course_category_id' => 42,
                    'name' => '小学生コース',
                    'description' => '小学生を鍛えるピラティスのコースです。',
                    'course_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-04-01',
                    'end_date' => null,
                    'created_at' => '2025-03-01',
                    'updated_at' => null,
                    'deleted_at' => null,
                ],
            ]
        );
    }
}
