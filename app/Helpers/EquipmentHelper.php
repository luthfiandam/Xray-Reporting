<?php

namespace App\Helpers;

use App\Models\Equipment;

class EquipmentHelper
{
    /**
     * Get status label in Indonesian
     */
    public static function statusLabel(string $status): string
    {
        return match($status) {
            'operational' => 'Operasional',
            'maintenance' => 'Dalam Perbaikan',
            'out_of_service' => 'Tidak Beroperasi',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get status badge CSS class
     */
    public static function statusBadgeClass(string $status): string
    {
        return match($status) {
            'operational' => 'badge-success',
            'maintenance' => 'badge-warning',
            'out_of_service' => 'badge-danger',
            default => 'badge-light',
        };
    }

    /**
     * Get view mode label
     */
    public static function viewModeLabel(string $viewMode): string
    {
        return match($viewMode) {
            'single_view' => 'Single View',
            'dual_view' => 'Dual View',
            'not_applicable' => 'Tidak Berlaku',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Check if equipment requires dual generator
     */
    public static function hasDualGenerator(Equipment $equipment): bool
    {
        return !empty($equipment->generator_serial_a) && !empty($equipment->generator_serial_b);
    }

    /**
     * Get equipment full info
     */
    public static function getFullInfo(Equipment $equipment): string
    {
        return sprintf(
            '%s (%s) - %s',
            $equipment->name,
            $equipment->equipment_code,
            $equipment->location->name ?? 'Lokasi Tidak Ada'
        );
    }

    /**
     * Check if equipment needs maintenance
     */
    public static function needsMaintenance(Equipment $equipment): bool
    {
        $lastWorkOrder = $equipment->workOrders()
            ->where('status', 'closed')
            ->latest('closed_at')
            ->first();

        if (!$lastWorkOrder) {
            return true;
        }

        // Check based on frequency (simplified)
        return $lastWorkOrder->closed_at->diffInDays(now()) > 30;
    }
}