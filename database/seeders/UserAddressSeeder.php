<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_addresses')->insert([
            [
                'user_id' => 1,
                'postalcode' => '6308303',
                'prefecture' => '奈良県',
                'city' => '奈良市',
                'address1' => '南紀寺町2丁目274-3',
                'address2' => '萠黄アパート103号',
                'phone_number' => '09095809257',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
