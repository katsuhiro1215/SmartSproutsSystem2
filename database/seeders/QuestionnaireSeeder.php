<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questionnaires')->insert(
            [
                [
                    'name' => 'アンケート1',
                    'main_description' => 'アンケート1の内容です。',
                    'sub_description' => 'アンケート1の補足説明です。',
                    'annotation' => 'アンケート1の注釈です。',
                    'questionnaire_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-01-01',
                    'start_time' => '09:00:00',
                    'end_date' => '2025-01-31',
                    'end_time' => '18:00:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'name' => 'アンケート2',
                    'main_description' => 'アンケート2の内容です。',
                    'sub_description' => 'アンケート2の補足説明です。',
                    'annotation' => null,
                    'questionnaire_photo_path' => null,
                    'status' => true,
                    'start_date' => '2025-02-01',
                    'start_time' => '10:00:00',
                    'end_date' => '2025-02-28',
                    'end_time' => '17:00:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'name' => 'アンケート3',
                    'main_description' => 'アンケート3の内容です。',
                    'sub_description' => null,
                    'annotation' => 'アンケート3の注釈です。',
                    'questionnaire_photo_path' => null,
                    'status' => false,
                    'start_date' => '2025-03-01',
                    'start_time' => '08:00:00',
                    'end_date' => '2025-03-31',
                    'end_time' => '20:00:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
            ]
        );
    }
}
