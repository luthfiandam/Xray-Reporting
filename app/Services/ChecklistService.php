<?php

namespace App\Services;

use App\Models\ChecklistResult;
use App\Models\WorkOrder;

class ChecklistService
{
    /**
     * Get checklist results for work order
     */
    public function getByWorkOrder(int $workOrderId)
    {
        return ChecklistResult::where('work_order_id', $workOrderId)
            ->with(['checklistTemplateItem', 'completedBy'])
            ->orderBy('sequence')
            ->get();
    }

    /**
     * Get checklist completion percentage
     */
    public function getCompletionPercentage(WorkOrder $workOrder): float
    {
        $template = $workOrder->checklistTemplate;
        $totalItems = $template->items()->where('is_active', true)->count();

        if ($totalItems === 0) {
            return 100;
        }

        $completedItems = ChecklistResult::where('work_order_id', $workOrder->id)
            ->where('result_status', '!=', null)
            ->count();

        return ($completedItems / $totalItems) * 100;
    }

    /**
     * Check if all required items are completed
     */
    public function isComplete(WorkOrder $workOrder): bool
    {
        $template = $workOrder->checklistTemplate;

        $requiredItems = $template->items()
            ->where('is_active', true)
            ->where('is_required', true)
            ->get();

        foreach ($requiredItems as $item) {
            $result = ChecklistResult::where('work_order_id', $workOrder->id)
                ->where('checklist_template_item_id', $item->id)
                ->first();

            if (!$result || $result->result_status === null) {
                return false;
            }
        }

        return true;
    }

    /**
     * Save checklist result
     */
    public function saveResult(int $workOrderId, int $itemId, array $data): ChecklistResult
    {
        $result = ChecklistResult::updateOrCreate(
            [
                'work_order_id' => $workOrderId,
                'checklist_template_item_id' => $itemId,
            ],
            $data
        );

        return $result;
    }

    /**
     * Get checklist summary
     */
    public function getSummary(WorkOrder $workOrder): array
    {
        $results = $this->getByWorkOrder($workOrder->id);

        return [
            'total_items' => $results->count(),
            'completed' => $results->where('result_status', '!=', null)->count(),
            'ok_count' => $results->where('result_status', 'ok')->count(),
            'not_ok_count' => $results->where('result_status', 'not_ok')->count(),
            'not_applicable_count' => $results->where('result_status', 'not_applicable')->count(),
            'completion_percentage' => $this->getCompletionPercentage($workOrder),
            'is_complete' => $this->isComplete($workOrder),
        ];
    }
}