<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAccessSeeder extends Seeder
{
    public function run()
    {
        // Define the roles with their associated routes in the `access` array
        $roles = [
            [
                'role' => 'admin',
                'access' => json_encode([
                    '/dashboard',
                    '/profile',
                    '/settings',
                    '/admin/panel', // Add more specific routes as needed
                ]),
            ],
            [
                'role' => 'agency',
                'access' => json_encode([
                    '/dashboard',
                    '/profile',
                    '/agency/manage',
                    // Add agency-specific routes here
                ]),
            ],
            [
                'role' => 'agent',
                'access' => json_encode([
                    '/dashboard',
                    '/profile',
                    '/agent/resources',
                    // Add agent-specific routes here
                ]),
            ],
        ];

        // Insert roles and their access permissions into the role_access table
        foreach ($roles as $role) {
            DB::table('role_access')->insert([
                'role' => $role['role'],
                'access' => $role['access'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
