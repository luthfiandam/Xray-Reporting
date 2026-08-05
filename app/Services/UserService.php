<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getPaginatedUsers(array $filters = [], array $sort = []): LengthAwarePaginator
    {
        $query = User::with('role');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        if (!empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['technician_code'])) {
            $query->where('technician_code', 'like', "%{$filters['technician_code']}%");
        }

        $sortBy = $sort['by'] ?? 'created_at';
        $sortDir = $sort['direction'] ?? 'desc';
        
        $allowedSortColumns = ['name', 'username', 'email', 'created_at', 'updated_at', 'last_login_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        $perPage = config('app_settings.pagination.default', 15);
        return $query->paginate($perPage);
    }

    public function getActiveUsers(): Collection
    {
        return User::where('status', 'active')
                   ->with('role')
                   ->orderBy('name')
                   ->get();
    }

    public function getUsersByRole(Role $role): Collection
    {
        return User::where('role_id', $role->id)
                   ->where('status', 'active')
                   ->orderBy('name')
                   ->get();
    }

    public function createUser(array $data): User
    {
        try {
            $user = User::create([
                'role_id' => $data['role_id'],
                'name' => $data['name'],
                'username' => strtolower($data['username']),
                'email' => strtolower($data['email']),
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'technician_code' => $data['technician_code'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]);

            Log::info('User created', [
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role->name,
                'created_by' => auth()->id(),
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'created_by' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function updateUser(User $user, array $data): User
    {
        try {
            $updateData = [
                'name' => $data['name'],
                'username' => strtolower($data['username']),
                'email' => strtolower($data['email']),
                'phone' => $data['phone'] ?? null,
                'technician_code' => $data['technician_code'] ?? null,
            ];

            if (isset($data['role_id'])) {
                $updateData['role_id'] = $data['role_id'];
            }

            if (isset($data['status'])) {
                $updateData['status'] = $data['status'];
            }

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            Log::info('User updated', [
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'updated_by' => auth()->id(),
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Failed to update user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'updated_by' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function resetPassword(User $user, string $newPassword): bool
    {
        try {
            $user->update(['password' => Hash::make($newPassword)]);

            Log::warning('User password reset', [
                'user_id' => $user->id,
                'username' => $user->username,
                'reset_by' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to reset password', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function suspendUser(User $user): bool
    {
        try {
            $user->update(['status' => 'suspended']);

            Log::warning('User suspended', [
                'user_id' => $user->id,
                'username' => $user->username,
                'suspended_by' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to suspend user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function deactivateUser(User $user): bool
    {
        try {
            $user->update(['status' => 'inactive']);

            Log::info('User deactivated', [
                'user_id' => $user->id,
                'username' => $user->username,
                'deactivated_by' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to deactivate user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function activateUser(User $user): bool
    {
        try {
            $user->update(['status' => 'active']);

            Log::info('User activated', [
                'user_id' => $user->id,
                'username' => $user->username,
                'activated_by' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to activate user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function getUserDetail(User $user): User
    {
        return $user->load('role');
    }

    public function getUserStats(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'by_role' => User::selectRaw('role_id, COUNT(*) as count')
                            ->with('role')
                            ->groupBy('role_id')
                            ->get()
                            ->mapWithKeys(fn($item) => [$item->role->name => $item->count]),
        ];
    }

    public function isUsernameAvailable(string $username, ?int $excludeUserId = null): bool
    {
        $query = User::where('username', strtolower($username));

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        return !$query->exists();
    }

    public function isEmailAvailable(string $email, ?int $excludeUserId = null): bool
    {
        $query = User::where('email', strtolower($email));

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        return !$query->exists();
    }

    public function isTechnicianCodeAvailable(string $technicianCode, ?int $excludeUserId = null): bool
    {
        $query = User::where('technician_code', $technicianCode);

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        return !$query->exists();
    }

    public function updateLastLogin(User $user): bool
    {
        try {
            $user->update(['last_login_at' => now()]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update last login', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function getAvailableRoles(): Collection
    {
        return Role::where('is_active', true)
                   ->orderBy('name')
                   ->get();
    }

    public function getStatusOptions(): array
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Nonaktif',
            'suspended' => 'Ditangguhkan',
        ];
    }
}