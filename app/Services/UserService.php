<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\Paginate;

class UserService
{
    /**
     * Get all active users with pagination
     */
    public function getAllActive(int $perPage = 15)
    {
        return User::where('status', 'active')
            ->with('role')
            ->paginate($perPage);
    }

    /**
     * Get user by username
     */
    public function getByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    /**
     * Get user by email
     */
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Get users by role
     */
    public function getByRole(string $roleName, int $perPage = 15)
    {
        return User::whereHas('role', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })
        ->with('role')
        ->paginate($perPage);
    }

    /**
     * Create new user
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update user
     */
    public function update(User $user, array $data): bool
    {
        // Don't update password if not provided
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $user->update($data);
    }

    /**
     * Deactivate user
     */
    public function deactivate(User $user): bool
    {
        return $user->update(['status' => 'inactive']);
    }

    /**
     * Activate user
     */
    public function activate(User $user): bool
    {
        return $user->update(['status' => 'active']);
    }

    /**
     * Check if username exists
     */
    public function usernameExists(string $username, ?int $exceptUserId = null): bool
    {
        $query = User::where('username', $username);

        if ($exceptUserId) {
            $query->where('id', '!=', $exceptUserId);
        }

        return $query->exists();
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $exceptUserId = null): bool
    {
        $query = User::where('email', $email);

        if ($exceptUserId) {
            $query->where('id', '!=', $exceptUserId);
        }

        return $query->exists();
    }
}