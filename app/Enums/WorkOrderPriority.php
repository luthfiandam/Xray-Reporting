<?php

namespace App\Enums;

enum WorkOrderPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::LOW => 'Rendah',
            self::NORMAL => 'Normal',
            self::HIGH => 'Tinggi',
            self::CRITICAL => 'Kritis',
        };
    }

    /**
     * Get badge class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::LOW => 'badge-info',
            self::NORMAL => 'badge-secondary',
            self::HIGH => 'badge-warning',
            self::CRITICAL => 'badge-danger',
        };
    }

    /**
     * Get numeric value for sorting
     */
    public function sortValue(): int
    {
        return match($this) {
            self::LOW => 1,
            self::NORMAL => 2,
            self::HIGH => 3,
            self::CRITICAL => 4,
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