<?php

namespace App\Enums;

enum WorkOrderStatus: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case IN_PROGRESS = 'in_progress';
    case SUBMITTED = 'submitted';
    case APPROVED = 'approved';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SCHEDULED => 'Terjadwal',
            self::IN_PROGRESS => 'Sedang Dikerjakan',
            self::SUBMITTED => 'Diajukan',
            self::APPROVED => 'Disetujui',
            self::CLOSED => 'Selesai',
            self::CANCELLED => 'Dibatalkan',
        };
    }

    /**
     * Get badge class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::DRAFT => 'badge-secondary',
            self::SCHEDULED => 'badge-info',
            self::IN_PROGRESS => 'badge-primary',
            self::SUBMITTED => 'badge-warning',
            self::APPROVED => 'badge-success',
            self::CLOSED => 'badge-success',
            self::CANCELLED => 'badge-danger',
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