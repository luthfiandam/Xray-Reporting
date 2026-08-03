<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{
    /**
     * Handle the Report "creating" event.
     */
    public function creating(Report $report): void
    {
        // Set default status to queued
        if (!$report->status) {
            $report->status = 'queued';
        }

        // Set default version
        if (!$report->version) {
            $report->version = 1;
        }
    }

    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        \Log::info('Report queued for generation', [
            'report_id' => $report->id,
            'work_order_id' => $report->work_order_id,
            'report_type' => $report->report_type,
        ]);
    }

    /**
     * Handle the Report "updating" event.
     */
    public function updating(Report $report): void
    {
        // Log status changes
        if ($report->isDirty('status')) {
            \Log::info('Report status changed', [
                'report_id' => $report->id,
                'from' => $report->getOriginal('status'),
                'to' => $report->status,
            ]);

            // Set generated_at when status changes to generated
            if ($report->status === 'generated' && !$report->generated_at) {
                $report->generated_at = now();
            }
        }
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        \Log::info('Report updated', [
            'report_id' => $report->id,
            'status' => $report->status,
            'file_path' => $report->file_path,
        ]);
    }
}