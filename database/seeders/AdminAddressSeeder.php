<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_addresses')->insert([
            [
                'admin_id' => 1,
                'postalcode' => '1234567',
                'prefecture' => '東京都',
                'city' => '新宿区',
                'address1' => '西新宿2-8-1',
                'address2' => '新宿住友ビル',
                'phone_number' => '03-1234-5678',
                'is_default' => true,  
            ],
            [
                'admin_id' => 2,
                'postalcode' => '4567890',
                'prefecture' => '北海道',
                'city' => '札幌市',
                'address1' => '大通西1丁目',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 3,
                'postalcode' => '5678901',
                'prefecture' => '福岡県',
                'city' => '福岡市',
                'address1' => '天神2-1-1',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 4,
                'postalcode' => '6789012',
                'prefecture' => '沖縄県',
                'city' => '那覇市',
                'address1' => '久茂地3-1-1',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 5,
                'postalcode' => '7890123',
                'prefecture' => '京都府',
                'city' => '京都市',
                'address1' => '河原町通四条上ル',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 6,
                'postalcode' => '8901234',
                'prefecture' => '兵庫県',
                'city' => '神戸市',
                'address1' => '三宮町1丁目',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 7,
                'postalcode' => '9012345',
                'prefecture' => '広島県',
                'city' => '広島市',
                'address1' => '紙屋町1丁目',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
            [
                'admin_id' => 8,
                'postalcode' => '0123456',
                'prefecture' => '宮城県',
                'city' => '仙台市',
                'address1' => '青葉区中央1丁目',
                'address2' => '1-1',
                'phone_number' => null,
                'is_default' => false,  
            ],
        ]);
    }
}
