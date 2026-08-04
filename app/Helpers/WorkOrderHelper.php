<?php

namespace App\Helpers;

use App\Models\WorkOrder;
use Carbon\Carbon;

class WorkOrderHelper
{
    /**
     * Get status label in Indonesian
     */
    public static function statusLabel(string $status): string
    {
        return match($status) {
            'draft' => 'Draft',
            'scheduled' => 'Terjadwal',
            'in_progress' => 'Sedang Dikerjakan',
            'submitted' => 'Diajukan',
            'approved' => 'Disetujui',
            'closed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get status badge CSS class
     */
    public static function statusBadgeClass(string $status): string
    {
        return match($status) {
            'draft' => 'badge-secondary',
            'scheduled' => 'badge-info',
            'in_progress' => 'badge-primary',
            'submitted' => 'badge-warning',
            'approved' => 'badge-success',
            'closed' => 'badge-success',
            'cancelled' => 'badge-danger',
            default => 'badge-light',
        };
    }

    /**
     * Get priority label
     */
    public static function priorityLabel(string $priority): string
    {
        return match($priority) {
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'critical' => 'Kritis',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get priority badge CSS class
     */
    public static function priorityBadgeClass(string $priority): string
    {
        return match($priority) {
            'low' => 'badge-info',
            'normal' => 'badge-secondary',
            'high' => 'badge-warning',
            'critical' => 'badge-danger',
            default => 'badge-light',
        };
    }

    /**
     * Get days until due date
     */
    public static function daysUntilDue(WorkOrder $workOrder): ?int
    {
        if (!$workOrder->scheduled_at) {
            return null;
        }

        return Carbon::parse($workOrder->scheduled_at)->diffInDays(now(), false);
    }

    /**
     * Check if work order is overdue
     */
    public static function isOverdue(WorkOrder $workOrder): bool
    {
        if (!$workOrder->scheduled_at) {
            return false;
        }

        return Carbon::parse($workOrder->scheduled_at)->isPast() && 
               !in_array($workOrder->status, ['closed', 'cancelled']);
    }

    /**
     * Get days remaining to complete
     */
    public static function daysRemaining(WorkOrder $workOrder): ?string
    {
        $days = self::daysUntilDue($workOrder);

        if ($days === null) {
            return null;
        }

        if ($days < 0) {
            return sprintf('Terlambat %d hari', abs($days));
        }

        if ($days === 0) {
            return 'Hari ini';
        }

        return sprintf('%d hari lagi', $days);
    }

    /**
     * Calculate work order duration
     */
    public static function getDuration(WorkOrder $workOrder): ?string
    {
        if (!$workOrder->started_at) {
            return null;
        }

        $end = $workOrder->closed_at ?? now();
        $duration = Carbon::parse($workOrder->started_at)->diff($end);

        return sprintf(
            '%d hari %d jam %d menit',
            $duration->days,
            $duration->hours,
            $duration->minutes
        );
    }

    /**
     * Get completion percentage based on checklist
     */
    public static function getCompletionPercentage(WorkOrder $workOrder): float
    {
        $checklist = $workOrder->checklistResults;

        if ($checklist->isEmpty()) {
            return 0;
        }

        $completed = $checklist->where('result_status', '!=', null)->count();
        $total = $checklist->count();

        return ($completed / $total) * 100;
    }
}