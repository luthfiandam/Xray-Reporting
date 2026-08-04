<?php

namespace App\Services;

use App\Models\MeasurementResult;
use App\Models\WorkOrder;

class MeasurementService
{
    /**
     * Get measurement results for work order
     */
    public function getByWorkOrder(int $workOrderId)
    {
        return MeasurementResult::where('work_order_id', $workOrderId)
            ->with(['measurementTemplate', 'ocrResult', 'confirmedBy'])
            ->orderBy('sequence')
            ->get();
    }

    /**
     * Validate measurement value
     */
    public function validate(MeasurementResult $result): array
    {
        $errors = [];

        if ($result->final_value === null) {
            $errors[] = 'Nilai pengukuran tidak boleh kosong';
            return ['valid' => false, 'errors' => $errors];
        }

        if ($result->minimum_value !== null && $result->final_value < $result->minimum_value) {
            $errors[] = sprintf(
                'Nilai %s lebih rendah dari minimum (%s)',
                $result->final_value,
                $result->minimum_value
            );
        }

        if ($result->maximum_value !== null && $result->final_value > $result->maximum_value) {
            $errors[] = sprintf(
                'Nilai %s lebih tinggi dari maksimum (%s)',
                $result->final_value,
                $result->maximum_value
            );
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Save measurement result
     */
    public function saveResult(int $workOrderId, int $templateId, array $data): MeasurementResult
    {
        $result = MeasurementResult::updateOrCreate(
            [
                'work_order_id' => $workOrderId,
                'measurement_template_id' => $templateId,
            ],
            $data
        );

        return $result;
    }

    /**
     * Get measurement summary
     */
    public function getSummary(WorkOrder $workOrder): array
    {
        $results = $this->getByWorkOrder($workOrder->id);

        $withinRange = $results->where('is_within_range', true)->count();
        $outOfRange = $results->where('is_within_range', false)->count();

        return [
            'total' => $results->count(),
            'within_range' => $withinRange,
            'out_of_range' => $outOfRange,
            'percentage_within_range' => $results->count() > 0 ? ($withinRange / $results->count()) * 100 : 0,
        ];
    }

    /**
     * Check if all required measurements are completed
     */
    public function isComplete(WorkOrder $workOrder): bool
    {
        $template = $workOrder->checklistTemplate;

        $requiredMeasurements = $template->equipmentType->measurementTemplates()
            ->where('maintenance_frequency_id', $workOrder->maintenance_frequency_id)
            ->where('is_required', true)
            ->get();

        foreach ($requiredMeasurements as $measurement) {
            $result = MeasurementResult::where('work_order_id', $workOrder->id)
                ->where('measurement_template_id', $measurement->id)
                ->where('final_value', '!=', null)
                ->first();

            if (!$result) {
                return false;
            }
        }

        return true;
    }
}