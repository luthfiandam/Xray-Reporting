<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkOrder;

class WorkOrderPolicy
{
    /**
     * Determine whether the user can view any work orders.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Supervisor', 'Teknisi']);
    }

    /**
     * Determine whether the user can view the work order.
     */
    public function view(User $user, WorkOrder $workOrder): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Supervisor']) || 
               $workOrder->assigned_to === $user->id || 
               $workOrder->created_by === $user->id;
    }

    /**
     * Determine whether the user can create work orders.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Supervisor']);
    }

    /**
     * Determine whether the user can update the work order.
     */
    public function update(User $user, WorkOrder $workOrder): bool
    {
        // Only creator or supervisor can update
        if ($workOrder->status === 'closed' || $workOrder->status === 'approved') {
            return false;
        }

        return $user->role->name === 'Super Admin' || 
               $user->role->name === 'Supervisor' || 
               $workOrder->created_by === $user->id;
    }

    /**
     * Determine whether the user can delete the work order.
     */
    public function delete(User $user, WorkOrder $workOrder): bool
    {
        return $workOrder->status === 'draft' && 
               ($user->role->name === 'Super Admin' || $workOrder->created_by === $user->id);
    }

    /**
     * Determine whether the user can submit the work order.
     */
    public function submit(User $user, WorkOrder $workOrder): bool
    {
        return $workOrder->status === 'in_progress' && 
               $workOrder->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can approve the work order.
     */
    public function approve(User $user, WorkOrder $workOrder): bool
    {
        return $workOrder->status === 'submitted' && 
               in_array($user->role->name, ['Super Admin', 'Supervisor']);
    }

    /**
     * Determine whether the user can reopen the work order.
     */
    public function reopen(User $user, WorkOrder $workOrder): bool
    {
        return $workOrder->status === 'approved' && 
               $user->role->name === 'Super Admin';
    }
}