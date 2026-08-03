<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Administrator sistem dengan akses penuh',
                'is_active' => true,
            ],
            [
                'name' => 'Teknisi',
                'description' => 'Teknisi maintenance X-Ray',
                'is_active' => true,
            ],
            [
                'name' => 'Supervisor',
                'description' => 'Supervisor maintenance',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description'], 'is_active' => $role['is_active']]
            );
        }

        echo "✓ RoleSeeder completed\n";
    }
}