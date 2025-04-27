<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            [
                'type' => '個人',
                'name' => '個人事業主',
                'description' => '個人事業主です。',
                'email' => 'free@smartsprouts.jp',
                'organization_photo_path' => null,
                'organization_logo_path' => null,
                'postalcode' => '0000000',
                'prefecture' => '未登録',
                'city' => '未登録',
                'address1' => '未登録',
                'address2' => '未登録',
                'phone_number' => '0000000000',
                'fax_number' => null,
                'status' => true,
                'established_date' => null,
                'website' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'youtube' => null,
                'line' => null,
            ],
            [
                'type' => '法人',
                'name' => '株式会社 ケンコー社',
                'description' => '登山・キャンプ、アウトドア用品輸入・卸販売、こども向け体操教室事業。',
                'email' => 'info@kenkosya.com',
                'organization_photo_path' => null,
                'organization_logo_path' => null,
                'postalcode' => '5310072',
                'prefecture' => '大阪府',
                'city' => '大阪市北区',
                'address1' => '豊崎',
                'address2' => '1-3-11',
                'phone_number' => '0663742788',
                'fax_number' => '0663742256',
                'status' => true,
                'established_date' => '1979-8-1',
                'website' => 'https://kenkosya.com/',
                'facebook' => 'https://www.facebook.com/kenkosya',
                'twitter' => 'https://twitter.com/kenkosya_japan',
                'instagram' => 'https://www.instagram.com/kenkosya/',
                'youtube' => 'https://www.youtube.com/channel/UCC96IvcP8uf9THOwwc1Pp5Q',
                'line' => null,
            ],
        ]);
    }
}
