<?php

// database/seeders/AdminsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'user_id' => 1, // This should match the ID of a user in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // This should match the ID of a user in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more admin data as needed
        ]);
    }
}

