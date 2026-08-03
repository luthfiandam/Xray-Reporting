<?php

namespace Database\Seeders;

use App\Models\ChecklistCategory;
use Illuminate\Database\Seeder;

class ChecklistCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'code' => 'SAFETY',
                'name' => 'Keamanan',
                'description' => 'Pemeriksaan keamanan peralatan',
                'sequence' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'MECHANICAL',
                'name' => 'Mekanik',
                'description' => 'Pemeriksaan komponen mekanik',
                'sequence' => 20,
                'is_active' => true,
            ],
            [
                'code' => 'ELECTRICAL',
                'name' => 'Elektrik',
                'description' => 'Pemeriksaan sistem kelistrikan',
                'sequence' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'IMAGING',
                'name' => 'Pencitraan',
                'description' => 'Pemeriksaan kualitas citra',
                'sequence' => 40,
                'is_active' => true,
            ],
            [
                'code' => 'CALIBRATION',
                'name' => 'Kalibrasi',
                'description' => 'Pemeriksaan dan kalibrasi alat',
                'sequence' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ChecklistCategory::firstOrCreate(
                ['code' => $category['code']],
                $category
            );
        }

        echo "✓ ChecklistCategorySeeder completed\n";
    }
}