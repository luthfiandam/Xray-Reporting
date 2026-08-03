<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $teknisiRole = Role::where('name', 'Teknisi')->first();
        $supervisorRole = Role::where('name', 'Supervisor')->first();

        if (!$superAdminRole || !$teknisiRole || !$supervisorRole) {
            echo "❌ Roles not found. Please run RoleSeeder first.\n";
            return;
        }

        // Admin user
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'role_id' => $superAdminRole->id,
                'name' => 'Administrator',
                'email' => 'admin@xray.local',
                'phone' => '081234567890',
                'password' => bcrypt('admin123'),
                'technician_code' => 'ADMIN-001',
                'status' => 'active',
            ]
        );

        // Teknisi users
        $tekniisiNames = [
            'Adi Gunawan',
            'Budi Santoso',
            'Citra Dewi',
            'Doni Sutrisno',
            'Eka Putri',
        ];

        foreach ($tekniisiNames as $index => $name) {
            $code = sprintf('TEK-%03d', $index + 1);
            $username = 'teknisi' . ($index + 1);

            User::firstOrCreate(
                ['username' => $username],
                [
                    'role_id' => $teknisiRole->id,
                    'name' => $name,
                    'email' => strtolower($username) . '@xray.local',
                    'phone' => '0812345678' . str_pad($index, 2, '0', STR_PAD_LEFT),
                    'password' => bcrypt('password123'),
                    'technician_code' => $code,
                    'status' => 'active',
                ]
            );
        }

        // Supervisor users
        $supervisorNames = [
            'Fauzan Malik',
            'Gita Chandra',
            'Hendra Wijaya',
        ];

        foreach ($supervisorNames as $index => $name) {
            $code = sprintf('SUP-%03d', $index + 1);
            $username = 'supervisor' . ($index + 1);

            User::firstOrCreate(
                ['username' => $username],
                [
                    'role_id' => $supervisorRole->id,
                    'name' => $name,
                    'email' => strtolower($username) . '@xray.local',
                    'phone' => '0812345679' . str_pad($index, 2, '0', STR_PAD_LEFT),
                    'password' => bcrypt('password123'),
                    'technician_code' => $code,
                    'status' => 'active',
                ]
            );
        }

        echo "✓ UserSeeder completed\n";
    }
}