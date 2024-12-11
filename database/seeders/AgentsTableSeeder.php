<?php

// database/seeders/AgentsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agents')->insert([
            [
                'name' => 'Agent Smith',
                'agency_id' => 1, // This should match an ID in the agencies table
                'user_id' => 3, // This should match the ID of a user in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more agent data as needed
        ]);
    }
}

