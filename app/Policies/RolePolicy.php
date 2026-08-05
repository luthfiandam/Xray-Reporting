<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'Super Admin';
    }

    public function view(User $user, Role $role): bool
    {
        return $user->role->name === 'Super Admin';
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'Super Admin';
    }

    public function update(User $user, Role $role): bool
    {
        return $user->role->name === 'Super Admin';
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->role->name === 'Super Admin' && $user->id !== $role->id;
    }

    public function deactivate(User $user, Role $role): bool
    {
        return $user->role->name === 'Super Admin';
    }

    public function activate(User $user, Role $role): bool
    {
        return $user->role->name === 'Super Admin';
    }
}