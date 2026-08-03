<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        // Sanitize username
        $user->username = strtolower(trim($user->username));
        
        // Sanitize email
        if ($user->email) {
            $user->email = strtolower(trim($user->email));
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Log user creation
        \Log::info('User created', [
            'user_id' => $user->id,
            'username' => $user->username,
            'created_at' => now(),
        ]);
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        // Sanitize username if changed
        if ($user->isDirty('username')) {
            $user->username = strtolower(trim($user->username));
        }

        // Sanitize email if changed
        if ($user->isDirty('email') && $user->email) {
            $user->email = strtolower(trim($user->email));
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Log user update
        \Log::info('User updated', [
            'user_id' => $user->id,
            'username' => $user->username,
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Log user deletion
        \Log::info('User deleted', [
            'user_id' => $user->id,
            'username' => $user->username,
            'deleted_at' => now(),
        ]);
    }
}