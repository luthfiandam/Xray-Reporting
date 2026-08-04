<?php

namespace App\Enums;

enum EquipmentStatus: string
{
    case OPERATIONAL = 'operational';
    case MAINTENANCE = 'maintenance';
    case OUT_OF_SERVICE = 'out_of_service';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::OPERATIONAL => 'Operasional',
            self::MAINTENANCE => 'Dalam Perbaikan',
            self::OUT_OF_SERVICE => 'Tidak Beroperasi',
        };
    }

    /**
     * Get badge class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::OPERATIONAL => 'badge-success',
            self::MAINTENANCE => 'badge-warning',
            self::OUT_OF_SERVICE => 'badge-danger',
        };
    }

    /**
     * Get all values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}