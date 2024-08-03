<?php

// database/seeders/UsersTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'john@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'admin',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'admin2',
                'email' => 'admin2@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'admin',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'agency1',
                'email' => 'agency1@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'agency',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'agency2',
                'email' => 'agency2@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'agency',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'agency3',
                'email' => 'agency3@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'agency',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'agent',
                'email' => 'agent@example.com',
                'phone' => '1234567890',
                'image' => 'profile1.jpg',
                'role' => 'agency',
                'permissions' => 'all',
                'is_confirmed' => true,
                'confirmed_at' => Carbon::now(),
                'is_activated' => true,
                'activated_at' => Carbon::now(),
                'token' => Str::random(60),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Add more user data as needed
        ]);
    }
}
