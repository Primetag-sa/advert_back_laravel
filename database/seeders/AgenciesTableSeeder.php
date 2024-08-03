<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agencies')->insert([
            [
                'name' => 'Agent Smith',
                'user_id' => 3, // This should match the ID of a user in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more agent data as needed
        ]);
    }
}
