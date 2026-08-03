<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════╗\n";
        echo "║     XRAY REPORTING APP - DATABASE SEEDING          ║\n";
        echo "╚════════════════════════════════════════════════════╝\n\n";

        $seeders = [
            ['class' => RoleSeeder::class, 'name' => 'Seeding Roles'],
            ['class' => UserSeeder::class, 'name' => 'Seeding Users'],
            ['class' => MaintenanceFrequencySeeder::class, 'name' => 'Seeding Maintenance Frequencies'],
            ['class' => MaintenanceTypeSeeder::class, 'name' => 'Seeding Maintenance Types'],
            ['class' => EquipmentTypeSeeder::class, 'name' => 'Seeding Equipment Types'],
            ['class' => ChecklistCategorySeeder::class, 'name' => 'Seeding Checklist Categories'],
            ['class' => LocationSeeder::class, 'name' => 'Seeding Locations'],
            ['class' => EquipmentSeeder::class, 'name' => 'Seeding Equipments'],
        ];

        foreach ($seeders as $seeder) {
            echo $seeder['name'] . "...\n";
            $this->call($seeder['class']);
            echo "\n";
        }

        echo "╔════════════════════════════════════════════════════╗\n";
        echo "║        DATABASE SEEDING COMPLETED SUCCESSFULLY     ║\n";
        echo "╚════════════════════════════════════════════════════╝\n\n";

        echo "📋 DEFAULT ADMIN ACCOUNT:\n";
        echo "   Username: admin\n";
        echo "   Email:    admin@xray.local\n";
        echo "   Password: admin123\n";
        echo "   Role:     Super Admin\n\n";

        echo "🔧 DATA CREATED:\n";
        echo "   ✓ 3 Roles (Super Admin, Teknisi, Supervisor)\n";
        echo "   ✓ 9 Users (1 Admin + 5 Teknisi + 3 Supervisor)\n";
        echo "   ✓ 6 Maintenance Frequencies\n";
        echo "   ✓ 3 Maintenance Types\n";
        echo "   ✓ 4 Equipment Types\n";
        echo "   ✓ 5 Checklist Categories\n";
        echo "   ✓ 5 Locations\n";
        echo "   ✓ 10 Equipments\n\n";
    }
}