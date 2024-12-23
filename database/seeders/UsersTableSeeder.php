<?php

// database/seeders/UsersTableSeeder.php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
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
            // Add more user data as needed
        ]);
    }
}
