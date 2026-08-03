<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'XRAY-MOBILE',
                'name' => 'X-Ray Mobile',
                'description' => 'X-Ray unit mobile untuk portable examination',
                'is_active' => true,
            ],
            [
                'code' => 'XRAY-STATIONARY',
                'name' => 'X-Ray Stationary',
                'description' => 'X-Ray unit stationary di ruangan khusus',
                'is_active' => true,
            ],
            [
                'code' => 'XRAY-DIGITAL',
                'name' => 'X-Ray Digital',
                'description' => 'X-Ray dengan teknologi digital imaging',
                'is_active' => true,
            ],
            [
                'code' => 'CT-SCAN',
                'name' => 'CT Scan',
                'description' => 'Computed Tomography Scanner',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            EquipmentType::firstOrCreate(
                ['code' => $type['code']],
                $type
            );
        }

        echo "✓ EquipmentTypeSeeder completed\n";
    }
}