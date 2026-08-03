<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'code' => 'LOC-001',
                'name' => 'Ruangan Radiologi Lantai 1',
                'description' => 'Departemen Radiologi - Lantai 1 Gedung A',
                'parent_id' => null,
                'is_active' => true,
            ],
            [
                'code' => 'LOC-002',
                'name' => 'Ruangan Radiologi Lantai 2',
                'description' => 'Departemen Radiologi - Lantai 2 Gedung A',
                'parent_id' => null,
                'is_active' => true,
            ],
            [
                'code' => 'LOC-003',
                'name' => 'Ruangan Radiologi Lantai 3',
                'description' => 'Departemen Radiologi - Lantai 3 Gedung B',
                'parent_id' => null,
                'is_active' => true,
            ],
            [
                'code' => 'LOC-004',
                'name' => 'Unit Portable Radiologi',
                'description' => 'Layanan portable X-Ray untuk ruang ICU dan kamar operasi',
                'parent_id' => null,
                'is_active' => true,
            ],
            [
                'code' => 'LOC-005',
                'name' => 'Laboratorium Imaging Utama',
                'description' => 'Pusat laboratorium imaging dan diagnostic center',
                'parent_id' => null,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                ['code' => $location['code']],
                $location
            );
        }

        echo "✓ LocationSeeder completed\n";
    }
}