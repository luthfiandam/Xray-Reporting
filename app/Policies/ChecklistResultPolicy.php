<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChecklistResult;

class ChecklistResultPolicy
{
    /**
     * Determine whether the user can view the checklist result.
     */
    public function view(User $user, ChecklistResult $result): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Supervisor']) || 
               $result->workOrder->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create checklist results.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Teknisi', 'Supervisor']);
    }

    /**
     * Determine whether the user can update the checklist result.
     */
    public function update(User $user, ChecklistResult $result): bool
    {
        return $result->workOrder->assigned_to === $user->id || 
               $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can delete the checklist result.
     */
    public function delete(User $user, ChecklistResult $result): bool
    {
        return $result->workOrder->status === 'draft' && 
               ($result->workOrder->assigned_to === $user->id || $user->role->name === 'Super Admin');
    }
}