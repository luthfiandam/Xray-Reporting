<?php

namespace Database\Seeders;

use App\Models\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'PM',
                'name' => 'Preventive Maintenance',
                'description' => 'Maintenance rutin untuk pencegahan',
                'is_active' => true,
            ],
            [
                'code' => 'CM',
                'name' => 'Corrective Maintenance',
                'description' => 'Maintenance untuk perbaikan kerusakan',
                'is_active' => true,
            ],
            [
                'code' => 'INSPECTION',
                'name' => 'Inspection',
                'description' => 'Pemeriksaan berkala peralatan',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            MaintenanceType::firstOrCreate(
                ['code' => $type['code']],
                $type
            );
        }

        echo "✓ MaintenanceTypeSeeder completed\n";
    }
}