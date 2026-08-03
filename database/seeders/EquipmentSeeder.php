<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Location;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $locations = Location::all()->keyBy('code');
        $equipmentTypes = EquipmentType::all()->keyBy('code');

        $equipments = [
            // Lokasi LOC-001
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-STATIONARY']->id,
                'location_id' => $locations['LOC-001']->id,
                'equipment_code' => 'XRAY-001',
                'name' => 'X-Ray Unit SCP Line C',
                'brand' => 'Siemens',
                'model' => 'AXIOM Artis dFC',
                'view_mode' => 'single_view',
                'serial_number' => 'XR-2022-001',
                'generator_serial_a' => 'GEN-A-001',
                'detector_serial' => 'DET-001',
                'qr_code' => 'XRAY001QR',
                'installation_date' => '2022-01-15',
                'status' => 'operational',
            ],
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-DIGITAL']->id,
                'location_id' => $locations['LOC-001']->id,
                'equipment_code' => 'XRAY-002',
                'name' => 'X-Ray Digital Unit 1',
                'brand' => 'GE Healthcare',
                'model' => 'Optima XR240',
                'view_mode' => 'not_applicable',
                'serial_number' => 'XR-2023-001',
                'detector_serial' => 'DET-002',
                'qr_code' => 'XRAY002QR',
                'installation_date' => '2023-03-20',
                'status' => 'operational',
            ],
            // Lokasi LOC-002
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-STATIONARY']->id,
                'location_id' => $locations['LOC-002']->id,
                'equipment_code' => 'XRAY-003',
                'name' => 'X-Ray Unit VIP Room',
                'brand' => 'Philips',
                'model' => 'DigitalDiagnost C90',
                'view_mode' => 'dual_view',
                'serial_number' => 'XR-2022-002',
                'generator_serial_a' => 'GEN-A-002',
                'generator_serial_b' => 'GEN-B-002',
                'detector_serial' => 'DET-003',
                'qr_code' => 'XRAY003QR',
                'installation_date' => '2022-06-10',
                'status' => 'operational',
            ],
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-DIGITAL']->id,
                'location_id' => $locations['LOC-002']->id,
                'equipment_code' => 'XRAY-004',
                'name' => 'X-Ray Digital Unit 2',
                'brand' => 'Canon',
                'model' => 'CXDI Detector',
                'view_mode' => 'not_applicable',
                'serial_number' => 'XR-2023-002',
                'detector_serial' => 'DET-004',
                'qr_code' => 'XRAY004QR',
                'installation_date' => '2023-05-12',
                'status' => 'operational',
            ],
            // Lokasi LOC-003
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-STATIONARY']->id,
                'location_id' => $locations['LOC-003']->id,
                'equipment_code' => 'XRAY-005',
                'name' => 'X-Ray Unit Premium',
                'brand' => 'Siemens',
                'model' => 'AXIOM Artis dFA',
                'view_mode' => 'dual_view',
                'serial_number' => 'XR-2022-003',
                'generator_serial_a' => 'GEN-A-003',
                'generator_serial_b' => 'GEN-B-003',
                'detector_serial' => 'DET-005',
                'qr_code' => 'XRAY005QR',
                'installation_date' => '2022-09-05',
                'status' => 'operational',
            ],
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['CT-SCAN']->id,
                'location_id' => $locations['LOC-003']->id,
                'equipment_code' => 'CT-001',
                'name' => 'CT Scan Unit Spiral',
                'brand' => 'GE Healthcare',
                'model' => 'Optima CT660',
                'view_mode' => 'not_applicable',
                'serial_number' => 'CT-2023-001',
                'detector_serial' => 'DET-CT-001',
                'qr_code' => 'CT001QR',
                'installation_date' => '2023-02-14',
                'status' => 'operational',
            ],
            // Lokasi LOC-004 (Portable)
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-MOBILE']->id,
                'location_id' => $locations['LOC-004']->id,
                'equipment_code' => 'XRAY-PORT-001',
                'name' => 'X-Ray Mobile Unit 1',
                'brand' => 'Philips',
                'model' => 'MobileDiagnost',
                'view_mode' => 'single_view',
                'serial_number' => 'XR-MOBILE-001',
                'generator_serial_a' => 'GEN-MOB-001',
                'detector_serial' => 'DET-MOB-001',
                'qr_code' => 'XRAYPORT001QR',
                'installation_date' => '2021-08-20',
                'status' => 'operational',
            ],
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-MOBILE']->id,
                'location_id' => $locations['LOC-004']->id,
                'equipment_code' => 'XRAY-PORT-002',
                'name' => 'X-Ray Mobile Unit 2',
                'brand' => 'GE Healthcare',
                'model' => 'Optima XR200',
                'view_mode' => 'single_view',
                'serial_number' => 'XR-MOBILE-002',
                'generator_serial_a' => 'GEN-MOB-002',
                'detector_serial' => 'DET-MOB-002',
                'qr_code' => 'XRAYPORT002QR',
                'installation_date' => '2022-11-08',
                'status' => 'operational',
            ],
            // Lokasi LOC-005 (Main Lab)
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['XRAY-DIGITAL']->id,
                'location_id' => $locations['LOC-005']->id,
                'equipment_code' => 'XRAY-LAB-001',
                'name' => 'X-Ray Lab Main Unit',
                'brand' => 'Siemens',
                'model' => 'AXIOM Prime',
                'view_mode' => 'not_applicable',
                'serial_number' => 'XR-LAB-001',
                'detector_serial' => 'DET-LAB-001',
                'qr_code' => 'XRAYLAB001QR',
                'installation_date' => '2022-04-11',
                'status' => 'operational',
            ],
            [
                'uuid' => Str::uuid(),
                'equipment_type_id' => $equipmentTypes['CT-SCAN']->id,
                'location_id' => $locations['LOC-005']->id,
                'equipment_code' => 'CT-LAB-001',
                'name' => 'CT Scan Lab Unit',
                'brand' => 'Philips',
                'model' => 'IQon Spectral CT',
                'view_mode' => 'not_applicable',
                'serial_number' => 'CT-LAB-001',
                'detector_serial' => 'DET-CT-LAB-001',
                'qr_code' => 'CTLAB001QR',
                'installation_date' => '2023-07-19',
                'status' => 'operational',
            ],
        ];

        foreach ($equipments as $equipment) {
            Equipment::firstOrCreate(
                ['equipment_code' => $equipment['equipment_code']],
                $equipment
            );
        }

        echo "✓ EquipmentSeeder completed\n";
    }
}