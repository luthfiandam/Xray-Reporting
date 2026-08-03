<?php

namespace App\Observers;

use App\Models\Equipment;
use Illuminate\Support\Str;

class EquipmentObserver
{
    /**
     * Handle the Equipment "creating" event.
     */
    public function creating(Equipment $equipment): void
    {
        // Generate UUID if not provided
        if (!$equipment->uuid) {
            $equipment->uuid = Str::uuid();
        }

        // Generate QR code if not provided
        if (!$equipment->qr_code) {
            $equipment->qr_code = $this->generateQrCode($equipment->equipment_code);
        }
    }

    /**
     * Handle the Equipment "created" event.
     */
    public function created(Equipment $equipment): void
    {
        \Log::info('Equipment created', [
            'equipment_id' => $equipment->id,
            'equipment_code' => $equipment->equipment_code,
            'name' => $equipment->name,
        ]);
    }

    /**
     * Handle the Equipment "updating" event.
     */
    public function updating(Equipment $equipment): void
    {
        // Log status changes
        if ($equipment->isDirty('status')) {
            \Log::info('Equipment status changed', [
                'equipment_id' => $equipment->id,
                'from_status' => $equipment->getOriginal('status'),
                'to_status' => $equipment->status,
            ]);
        }
    }

    /**
     * Handle the Equipment "updated" event.
     */
    public function updated(Equipment $equipment): void
    {
        \Log::info('Equipment updated', [
            'equipment_id' => $equipment->id,
            'equipment_code' => $equipment->equipment_code,
            'status' => $equipment->status,
        ]);
    }

    /**
     * Generate QR code
     */
    private function generateQrCode(string $equipmentCode): string
    {
        return strtoupper($equipmentCode) . '-' . Str::random(8);
    }
}