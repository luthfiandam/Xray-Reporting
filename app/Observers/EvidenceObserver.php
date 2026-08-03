<?php

namespace App\Observers;

use App\Models\Evidence;
use Illuminate\Support\Str;

class EvidenceObserver
{
    /**
     * Handle the Evidence "creating" event.
     */
    public function creating(Evidence $evidence): void
    {
        // Generate UUID if not provided
        if (!$evidence->uuid) {
            $evidence->uuid = Str::uuid();
        }

        // Set watermark status to pending
        if (!$evidence->watermark_status) {
            $evidence->watermark_status = 'pending';
        }

        // Set sequence if not provided
        if (!$evidence->sequence) {
            $evidence->sequence = 100;
        }
    }

    /**
     * Handle the Evidence "created" event.
     */
    public function created(Evidence $evidence): void
    {
        \Log::info('Evidence uploaded', [
            'evidence_id' => $evidence->id,
            'work_order_id' => $evidence->work_order_id,
            'file_size' => $evidence->file_size,
            'mime_type' => $evidence->mime_type,
        ]);
    }

    /**
     * Handle the Evidence "updating" event.
     */
    public function updating(Evidence $evidence): void
    {
        // Log watermark status changes
        if ($evidence->isDirty('watermark_status')) {
            \Log::info('Evidence watermark status changed', [
                'evidence_id' => $evidence->id,
                'from_status' => $evidence->getOriginal('watermark_status'),
                'to_status' => $evidence->watermark_status,
            ]);
        }
    }

    /**
     * Handle the Evidence "deleted" event.
     */
    public function deleted(Evidence $evidence): void
    {
        \Log::info('Evidence soft deleted', [
            'evidence_id' => $evidence->id,
            'work_order_id' => $evidence->work_order_id,
        ]);

        // Optionally delete physical files here
        // Storage::delete([$evidence->original_path, $evidence->watermarked_path, $evidence->thumbnail_path]);
    }
}