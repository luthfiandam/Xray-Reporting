<?php

namespace App\Observers;

use App\Models\MeasurementResult;

class MeasurementResultObserver
{
    /**
     * Handle the MeasurementResult "creating" event.
     */
    public function creating(MeasurementResult $result): void
    {
        // Set default input source
        if (!$result->input_source) {
            $result->input_source = 'manual';
        }

        // Set confirmation timestamp
        if (!$result->confirmed_at) {
            $result->confirmed_at = now();
        }
    }

    /**
     * Handle the MeasurementResult "created" event.
     */
    public function created(MeasurementResult $result): void
    {
        // Validate measurement value
        $this->validateMeasurement($result);

        \Log::debug('Measurement result created', [
            'result_id' => $result->id,
            'measurement_code' => $result->measurement_code,
            'final_value' => $result->final_value,
        ]);
    }

    /**
     * Handle the MeasurementResult "updating" event.
     */
    public function updating(MeasurementResult $result): void
    {
        // Update final value based on input source
        if ($result->isDirty('ocr_value') || $result->isDirty('manual_value') || $result->isDirty('input_source')) {
            $this->updateFinalValue($result);
        }

        // Validate range
        if ($result->isDirty('final_value')) {
            $this->validateMeasurement($result);
        }
    }

    /**
     * Handle the MeasurementResult "updated" event.
     */
    public function updated(MeasurementResult $result): void
    {
        \Log::debug('Measurement result updated', [
            'result_id' => $result->id,
            'final_value' => $result->final_value,
            'within_range' => $result->is_within_range,
        ]);
    }

    /**
     * Update final value based on input source
     */
    private function updateFinalValue(MeasurementResult $result): void
    {
        if ($result->input_source === 'ocr' || $result->input_source === 'ocr_edited') {
            $result->final_value = $result->ocr_value;
        } else {
            $result->final_value = $result->manual_value;
        }
    }

    /**
     * Validate measurement against min/max
     */
    private function validateMeasurement(MeasurementResult $result): void
    {
        if ($result->final_value === null) {
            $result->is_within_range = null;
            $result->validation_status = 'not_validated';
            return;
        }

        $isWithinRange = true;

        if ($result->minimum_value !== null && $result->final_value < $result->minimum_value) {
            $isWithinRange = false;
        }

        if ($result->maximum_value !== null && $result->final_value > $result->maximum_value) {
            $isWithinRange = false;
        }

        $result->is_within_range = $isWithinRange;
        $result->validation_status = $isWithinRange ? 'valid' : 'invalid';
    }
}