<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool
    {
        return in_array($authUser->role->name, ['Super Admin', 'Supervisor']);
    }

    public function view(User $authUser, User $user): bool
    {
        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->role->name === 'Supervisor') {
            return $user->role->name !== 'Super Admin';
        }

        return $authUser->id === $user->id;
    }

    public function create(User $authUser): bool
    {
        return $authUser->role->name === 'Super Admin';
    }

    public function update(User $authUser, User $user): bool
    {
        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->id === $user->id) {
            return true;
        }

        return false;
    }

    public function delete(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        return $authUser->role->name === 'Super Admin';
    }

    public function deactivate(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->role->name === 'Supervisor') {
            return $user->role->name === 'Teknisi';
        }

        return false;
    }

    public function activate(User $authUser, User $user): bool
    {
        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->role->name === 'Supervisor') {
            return $user->role->name === 'Teknisi';
        }

        return false;
    }

    public function suspend(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->role->name === 'Supervisor') {
            return $user->role->name === 'Teknisi';
        }

        return false;
    }

    public function resetPassword(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        if ($authUser->role->name === 'Super Admin') {
            return true;
        }

        if ($authUser->role->name === 'Supervisor') {
            return $user->role->name === 'Teknisi';
        }

        return false;
    }

    public function changeRole(User $authUser, User $user): bool
    {
        return $authUser->role->name === 'Super Admin';
    }
}