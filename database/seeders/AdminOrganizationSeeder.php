<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_organization')->insert(
            [
                [
                    'admin_id' => 2,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 3,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 4,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 5,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 6,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 7,
                    'organization_id' => 2,
                ],
                [
                    'admin_id' => 8,
                    'organization_id' => 2,
                ],
            ],
        );
    }
}
