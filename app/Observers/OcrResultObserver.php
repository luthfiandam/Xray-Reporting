<?php

namespace App\Observers;

use App\Models\OcrResult;

class OcrResultObserver
{
    /**
     * Handle the OcrResult "creating" event.
     */
    public function creating(OcrResult $result): void
    {
        // Set default status to queued
        if (!$result->status) {
            $result->status = 'queued';
        }

        // Set default review status
        if (!$result->review_status) {
            $result->review_status = 'pending';
        }
    }

    /**
     * Handle the OcrResult "created" event.
     */
    public function created(OcrResult $result): void
    {
        \Log::info('OCR result created', [
            'result_id' => $result->id,
            'work_order_id' => $result->work_order_id,
            'status' => $result->status,
            'engine' => $result->engine_name,
        ]);
    }

    /**
     * Handle the OcrResult "updating" event.
     */
    public function updating(OcrResult $result): void
    {
        // Log status changes
        if ($result->isDirty('status')) {
            \Log::info('OCR status changed', [
                'result_id' => $result->id,
                'from' => $result->getOriginal('status'),
                'to' => $result->status,
            ]);
        }

        // Log review changes
        if ($result->isDirty('review_status')) {
            \Log::info('OCR review status changed', [
                'result_id' => $result->id,
                'from' => $result->getOriginal('review_status'),
                'to' => $result->review_status,
            ]);

            // Set reviewed_at when status changes
            if ($result->review_status !== 'pending' && !$result->reviewed_at) {
                $result->reviewed_at = now();
            }
        }
    }

    /**
     * Handle the OcrResult "updated" event.
     */
    public function updated(OcrResult $result): void
    {
        \Log::debug('OCR result updated', [
            'result_id' => $result->id,
            'status' => $result->status,
            'review_status' => $result->review_status,
        ]);
    }
}