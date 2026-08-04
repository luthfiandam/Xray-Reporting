<?php

namespace App\Services;

use App\Models\WorkOrder;
use Carbon\Carbon;

class WorkOrderService
{
    /**
     * Get all work orders by status
     */
    public function getByStatus(string $status, int $perPage = 15)
    {
        return WorkOrder::where('status', $status)
            ->with(['equipment', 'maintenanceType', 'maintenanceFrequency', 'assignedTo', 'createdBy'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get work orders assigned to user
     */
    public function getAssignedToUser(int $userId, int $perPage = 15)
    {
        return WorkOrder::where('assigned_to', $userId)
            ->with(['equipment', 'maintenanceType', 'maintenanceFrequency'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get work orders created by user
     */
    public function getCreatedByUser(int $userId, int $perPage = 15)
    {
        return WorkOrder::where('created_by', $userId)
            ->with(['equipment', 'maintenanceType', 'maintenanceFrequency', 'assignedTo'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get pending work orders (draft or scheduled)
     */
    public function getPending(int $perPage = 15)
    {
        return WorkOrder::whereIn('status', ['draft', 'scheduled'])
            ->with(['equipment', 'assignedTo'])
            ->orderBy('scheduled_at')
            ->paginate($perPage);
    }

    /**
     * Get overdue work orders
     */
    public function getOverdue()
    {
        return WorkOrder::where('status', '!=', 'closed')
            ->where('scheduled_at', '<', Carbon::now())
            ->with(['equipment', 'assignedTo'])
            ->latest('scheduled_at')
            ->get();
    }

    /**
     * Create work order
     */
    public function create(array $data): WorkOrder
    {
        return WorkOrder::create($data);
    }

    /**
     * Update work order
     */
    public function update(WorkOrder $workOrder, array $data): bool
    {
        return $workOrder->update($data);
    }

    /**
     * Change work order status
     */
    public function changeStatus(WorkOrder $workOrder, string $newStatus): bool
    {
        return $workOrder->update(['status' => $newStatus]);
    }

    /**
     * Start work order
     */
    public function start(WorkOrder $workOrder): bool
    {
        return $this->changeStatus($workOrder, 'in_progress');
    }

    /**
     * Submit work order
     */
    public function submit(WorkOrder $workOrder, array $data): bool
    {
        $data['status'] = 'submitted';
        $data['submitted_at'] = Carbon::now();

        return $workOrder->update($data);
    }

    /**
     * Approve work order
     */
    public function approve(WorkOrder $workOrder, int $approvedBy): bool
    {
        return $workOrder->update([
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => Carbon::now(),
        ]);
    }

    /**
     * Close work order
     */
    public function close(WorkOrder $workOrder): bool
    {
        return $workOrder->update([
            'status' => 'closed',
            'closed_at' => Carbon::now(),
        ]);
    }

    /**
     * Reopen work order
     */
    public function reopen(WorkOrder $workOrder): bool
    {
        return $workOrder->update([
            'status' => 'in_progress',
            'approved_by' => null,
            'approved_at' => null,
            'closed_at' => null,
        ]);
    }

    /**
     * Get work order statistics
     */
    public function getStatistics()
    {
        return [
            'total' => WorkOrder::count(),
            'draft' => WorkOrder::where('status', 'draft')->count(),
            'in_progress' => WorkOrder::where('status', 'in_progress')->count(),
            'submitted' => WorkOrder::where('status', 'submitted')->count(),
            'approved' => WorkOrder::where('status', 'approved')->count(),
            'closed' => WorkOrder::where('status', 'closed')->count(),
            'overdue' => $this->getOverdue()->count(),
        ];
    }

    /**
     * Get work orders for equipment
     */
    public function getForEquipment(int $equipmentId, int $perPage = 15)
    {
        return WorkOrder::where('equipment_id', $equipmentId)
            ->with(['maintenanceType', 'assignedTo'])
            ->latest()
            ->paginate($perPage);
    }
}