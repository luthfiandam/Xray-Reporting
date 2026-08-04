<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evidence;

class EvidencePolicy
{
    /**
     * Determine whether the user can view the evidence.
     */
    public function view(User $user, Evidence $evidence): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Supervisor']) || 
               $evidence->workOrder->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create evidence.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Admin', 'Teknisi']);
    }

    /**
     * Determine whether the user can delete the evidence.
     */
    public function delete(User $user, Evidence $evidence): bool
    {
        return $evidence->workOrder->status === 'draft' && 
               ($evidence->uploaded_by === $user->id || $user->role->name === 'Super Admin');
    }
}