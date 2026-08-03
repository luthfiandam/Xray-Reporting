<?php

namespace App\Observers;

use App\Models\WorkOrder;
use Illuminate\Support\Str;

class WorkOrderObserver
{
    /**
     * Handle the WorkOrder "creating" event.
     */
    public function creating(WorkOrder $workOrder): void
    {
        // Generate UUID if not provided
        if (!$workOrder->uuid) {
            $workOrder->uuid = Str::uuid();
        }

        // Generate work order number if not provided
        if (!$workOrder->work_order_number) {
            $workOrder->work_order_number = $this->generateWorkOrderNumber();
        }
    }

    /**
     * Handle the WorkOrder "created" event.
     */
    public function created(WorkOrder $workOrder): void
    {
        // Log work order creation
        \Log::info('Work order created', [
            'work_order_id' => $workOrder->id,
            'work_order_number' => $workOrder->work_order_number,
            'equipment_id' => $workOrder->equipment_id,
            'status' => $workOrder->status,
        ]);
    }

    /**
     * Handle the WorkOrder "updating" event.
     */
    public function updating(WorkOrder $workOrder): void
    {
        // Log status changes
        if ($workOrder->isDirty('status')) {
            $oldStatus = $workOrder->getOriginal('status');
            $newStatus = $workOrder->status;

            \Log::info('Work order status changed', [
                'work_order_id' => $workOrder->id,
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'changed_at' => now(),
            ]);
        }

        // Set started_at when status changes to in_progress
        if ($workOrder->isDirty('status') && $workOrder->status === 'in_progress' && !$workOrder->started_at) {
            $workOrder->started_at = now();
        }

        // Set submitted_at when status changes to submitted
        if ($workOrder->isDirty('status') && $workOrder->status === 'submitted' && !$workOrder->submitted_at) {
            $workOrder->submitted_at = now();
        }

        // Set approved_at when status changes to approved
        if ($workOrder->isDirty('status') && $workOrder->status === 'approved' && !$workOrder->approved_at) {
            $workOrder->approved_at = now();
        }

        // Set closed_at when status changes to closed
        if ($workOrder->isDirty('status') && $workOrder->status === 'closed' && !$workOrder->closed_at) {
            $workOrder->closed_at = now();
        }
    }

    /**
     * Handle the WorkOrder "updated" event.
     */
    public function updated(WorkOrder $workOrder): void
    {
        // Log work order update
        \Log::info('Work order updated', [
            'work_order_id' => $workOrder->id,
            'work_order_number' => $workOrder->work_order_number,
            'status' => $workOrder->status,
        ]);
    }

    /**
     * Handle the WorkOrder "deleted" event.
     */
    public function deleted(WorkOrder $workOrder): void
    {
        // Log work order deletion
        \Log::info('Work order deleted', [
            'work_order_id' => $workOrder->id,
            'work_order_number' => $workOrder->work_order_number,
        ]);
    }

    /**
     * Generate unique work order number
     */
    private function generateWorkOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $sequence = WorkOrder::whereDate('created_at', now())->count() + 1;
        return sprintf('WO-%s-%05d', $date, $sequence);
    }
}