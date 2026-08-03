<?php

namespace App\Observers;

use App\Models\ChecklistResult;

class ChecklistResultObserver
{
    /**
     * Handle the ChecklistResult "creating" event.
     */
    public function creating(ChecklistResult $result): void
    {
        // Set default sequence if not provided
        if (!$result->sequence) {
            $result->sequence = 100;
        }
    }

    /**
     * Handle the ChecklistResult "created" event.
     */
    public function created(ChecklistResult $result): void
    {
        \Log::debug('Checklist result created', [
            'result_id' => $result->id,
            'work_order_id' => $result->work_order_id,
            'item_name' => $result->item_name,
        ]);
    }

    /**
     * Handle the ChecklistResult "updating" event.
     */
    public function updating(ChecklistResult $result): void
    {
        // Set completed_at when status is set
        if ($result->isDirty('result_status') && $result->result_status && !$result->completed_at) {
            $result->completed_at = now();
        }
    }

    /**
     * Handle the ChecklistResult "updated" event.
     */
    public function updated(ChecklistResult $result): void
    {
        \Log::debug('Checklist result updated', [
            'result_id' => $result->id,
            'status' => $result->result_status,
        ]);
    }
}