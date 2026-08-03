<?php

namespace Database\Seeders;

use App\Models\MaintenanceFrequency;
use Illuminate\Database\Seeder;

class MaintenanceFrequencySeeder extends Seeder
{
    public function run(): void
    {
        $frequencies = [
            [
                'code' => 'DAILY',
                'name' => 'Harian',
                'interval_days' => 1,
                'sequence' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'WEEKLY',
                'name' => 'Mingguan',
                'interval_days' => 7,
                'sequence' => 20,
                'is_active' => true,
            ],
            [
                'code' => 'MONTHLY',
                'name' => 'Bulanan',
                'interval_days' => 30,
                'sequence' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'QUARTERLY',
                'name' => 'Triwulan',
                'interval_days' => 90,
                'sequence' => 40,
                'is_active' => true,
            ],
            [
                'code' => 'SEMI_ANNUAL',
                'name' => 'Semesteran',
                'interval_days' => 180,
                'sequence' => 50,
                'is_active' => true,
            ],
            [
                'code' => 'ANNUAL',
                'name' => 'Tahunan',
                'interval_days' => 365,
                'sequence' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($frequencies as $frequency) {
            MaintenanceFrequency::firstOrCreate(
                ['code' => $frequency['code']],
                $frequency
            );
        }

        echo "✓ MaintenanceFrequencySeeder completed\n";
    }
}