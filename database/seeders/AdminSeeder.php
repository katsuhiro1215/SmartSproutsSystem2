<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'username' => 'katsuhiro',
                'email' => 'katsuhiro.k1215@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => null,
                'role' => 'Owner',
            ],
            [
                'username' => 'nakamura',
                'email' => 'nakamura@kenkosya.com',
                'email_verified_at' => null,
                'password' => Hash::make('nakamura123kenkosya'),
                'remember_token' => null,
                'role' => 'SuperAdmin',
            ],
            [
                'username' => 'kondo',
                'email' => 'kondo@kenkosya.com',
                'email_verified_at' => null,
                'password' => Hash::make('kondo123kenkosya'),
                'remember_token' => null,
                'role' => 'Admin',
            ],
            [
                'username' => 'admin',
                'email' => 'admin@kenkosya.com',
                'email_verified_at' => null,
                'password' => Hash::make('admin123kenkosya'),
                'remember_token' => null,
                'role' => 'Admin',
            ],
            [
                'username' => 'keiri',
                'email' => 'keiri@kenkosya.com',
                'email_verified_at' => null,
                'password' => Hash::make('keiri123kenkosya'),
                'remember_token' => null,
                'role' => 'SubAdmin',
            ],
            [
                'username' => 'subAdmin',
                'email' => 'subadmin@kenkosya.com',
                'email_verified_at' => null,
                'password' => Hash::make('sub123kenkosya'),
                'remember_token' => null,
                'role' => 'SubAdmin',
            ],
            [
                'username' => 'nakamura',
                'email' => 'nakamura@shuplay.com',
                'email_verified_at' => null,
                'password' => Hash::make('nakamura123shuplay'),
                'remember_token' => null,
                'role' => 'Manager',
            ],
            [
                'username' => 'aiga',
                'email' => 'aiga@shuplay.com',
                'email_verified_at' => null,
                'password' => Hash::make('aiga123shuplay'),
                'remember_token' => null,
                'role' => 'Employee',
            ],
        ]);
    }
}
