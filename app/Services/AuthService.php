<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Authenticate user with credentials
     */
    public function login(array $credentials): bool
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        // Check if user is active
        if ($user->status !== 'active') {
            return false;
        }

        Auth::login($user, remember: false);

        return true;
    }

    /**
     * Get authenticated user
     */
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get user by email
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Get user by username
     */
    public function getUserByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    /**
     * Validate password for user
     */
    public function validatePassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Reset password
     */
    public function resetPassword(array $data): bool
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !$this->validatePassword($user, $data['current_password'])) {
            return false;
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return true;
    }

    /**
     * Change password for authenticated user
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!$this->validatePassword($user, $currentPassword)) {
            return false;
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return true;
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(User $user, string $roleName): bool
    {
        return $user->role->name === $roleName;
    }

    /**
     * Check if user has any of the roles
     */
    public function hasAnyRole(User $user, array $roleNames): bool
    {
        return in_array($user->role->name, $roleNames);
    }

    /**
     * Check if user has permission
     */
    public function hasPermission(User $user, string $permission): bool
    {
        // Super Admin memiliki semua permission
        if ($user->role->name === 'Super Admin') {
            return true;
        }

        // Define role-based permissions
        $rolePermissions = [
            'Teknisi' => [
                'work_order.view',
                'work_order.start',
                'work_order.submit',
                'checklist.fill',
                'measurement.fill',
                'evidence.upload',
                'ocr.use',
            ],
            'Supervisor' => [
                'work_order.view',
                'work_order.create',
                'work_order.assign',
                'work_order.approve',
                'checklist.view',
                'measurement.view',
                'evidence.view',
                'report.view',
                'report.generate',
            ],
        ];

        $userPermissions = $rolePermissions[$user->role->name] ?? [];

        return in_array($permission, $userPermissions);
    }

    /**
     * Log login activity
     */
    public function logLoginActivity(User $user, string $ipAddress): void
    {
        $user->update(['last_login_at' => now()]);

        \Log::info('User login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $ipAddress,
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log logout activity
     */
    public function logLogoutActivity(User $user, string $ipAddress): void
    {
        \Log::info('User logout', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $ipAddress,
        ]);
    }
}