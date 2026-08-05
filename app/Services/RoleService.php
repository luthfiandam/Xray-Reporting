<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class RoleService
{
    public function getPaginatedRoles(array $filters = [], array $sort = []): Paginator
    {
        $query = Role::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        $sortBy = $sort['by'] ?? 'created_at';
        $sortDir = $sort['direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDir);

        $perPage = config('app_settings.pagination.default', 15);
        return $query->paginate($perPage);
    }

    public function getActiveRoles()
    {
        return Role::where('is_active', true)
                   ->orderBy('name')
                   ->get();
    }

    public function createRole(array $data): Role
    {
        try {
            $role = Role::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);

            Log::info('Role created', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'user_id' => auth()->id(),
            ]);

            return $role;
        } catch (\Exception $e) {
            Log::error('Failed to create role', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function updateRole(Role $role, array $data): Role
    {
        try {
            $role->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);

            Log::info('Role updated', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'user_id' => auth()->id(),
            ]);

            return $role;
        } catch (\Exception $e) {
            Log::error('Failed to update role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function deactivateRole(Role $role): bool
    {
        try {
            if ($role->users()->where('is_active', true)->exists()) {
                throw new \Exception('Tidak dapat menonaktifkan role karena masih memiliki user aktif');
            }

            $role->update(['is_active' => false]);

            Log::info('Role deactivated', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'user_id' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to deactivate role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function activateRole(Role $role): bool
    {
        try {
            $role->update(['is_active' => true]);

            Log::info('Role activated', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'user_id' => auth()->id(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to activate role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw $e;
        }
    }

    public function getRoleDetail(Role $role): Role
    {
        return $role->load('users');
    }

    public function canDeleteRole(Role $role): bool
    {
        return !$role->users()->exists();
    }

    public function getRoleStats(): array
    {
        return [
            'total_roles' => Role::count(),
            'active_roles' => Role::where('is_active', true)->count(),
            'inactive_roles' => Role::where('is_active', false)->count(),
            'roles_with_users' => Role::has('users')->count(),
        ];
    }
}