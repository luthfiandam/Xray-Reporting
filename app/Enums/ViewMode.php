<?php

namespace App\Enums;

enum ViewMode: string
{
    case SINGLE_VIEW = 'single_view';
    case DUAL_VIEW = 'dual_view';
    case NOT_APPLICABLE = 'not_applicable';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::SINGLE_VIEW => 'Single View',
            self::DUAL_VIEW => 'Dual View',
            self::NOT_APPLICABLE => 'Tidak Berlaku',
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