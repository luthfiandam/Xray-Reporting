<?php

namespace App\Enums;

enum ChecklistResultStatus: string
{
    case OK = 'ok';
    case NOT_OK = 'not_ok';
    case NOT_APPLICABLE = 'not_applicable';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::OK => 'OK',
            self::NOT_OK => 'Tidak OK',
            self::NOT_APPLICABLE => 'Tidak Berlaku',
        };
    }

    /**
     * Get badge class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::OK => 'badge-success',
            self::NOT_OK => 'badge-danger',
            self::NOT_APPLICABLE => 'badge-secondary',
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