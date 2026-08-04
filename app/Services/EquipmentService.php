<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;

class EquipmentService
{
    /**
     * Get all operational equipment
     */
    public function getOperational(int $perPage = 15)
    {
        return Equipment::where('status', 'operational')
            ->with(['location', 'equipmentType'])
            ->paginate($perPage);
    }

    /**
     * Get equipment by location
     */
    public function getByLocation(int $locationId, int $perPage = 15)
    {
        return Equipment::where('location_id', $locationId)
            ->with(['location', 'equipmentType'])
            ->paginate($perPage);
    }

    /**
     * Get equipment by type
     */
    public function getByType(int $typeId, int $perPage = 15)
    {
        return Equipment::where('equipment_type_id', $typeId)
            ->with(['location', 'equipmentType'])
            ->paginate($perPage);
    }

    /**
     * Get equipment by QR code
     */
    public function getByQrCode(string $qrCode): ?Equipment
    {
        return Equipment::where('qr_code', $qrCode)
            ->with(['location', 'equipmentType'])
            ->first();
    }

    /**
     * Get equipment by equipment code
     */
    public function getByCode(string $code): ?Equipment
    {
        return Equipment::where('equipment_code', $code)
            ->with(['location', 'equipmentType'])
            ->first();
    }

    /**
     * Get equipment needing maintenance
     */
    public function getNeedingMaintenance()
    {
        return Equipment::where('status', 'operational')
            ->with(['location', 'equipmentType', 'workOrders'])
            ->get()
            ->filter(function ($equipment) {
                // Add your maintenance schedule logic here
                return true;
            });
    }

    /**
     * Create new equipment
     */
    public function create(array $data): Equipment
    {
        return Equipment::create($data);
    }

    /**
     * Update equipment
     */
    public function update(Equipment $equipment, array $data): bool
    {
        return $equipment->update($data);
    }

    /**
     * Update equipment status
     */
    public function updateStatus(Equipment $equipment, string $status): bool
    {
        return $equipment->update(['status' => $status]);
    }

    /**
     * Check if equipment code exists
     */
    public function codeExists(string $code, ?int $exceptId = null): bool
    {
        $query = Equipment::where('equipment_code', $code);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }

    /**
     * Get equipment with recent work orders
     */
    public function getWithRecentWorkOrders(int $limit = 10)
    {
        return Equipment::with(['location', 'equipmentType', 'workOrders' => function ($query) {
            $query->latest()->limit($limit);
        }])
        ->latest('updated_at')
        ->get();
    }
}