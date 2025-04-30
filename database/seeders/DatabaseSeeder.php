<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(AdminProfileSeeder::class);
        $this->call(AdminAddressSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(LessonSeeder::class);
    }
}
