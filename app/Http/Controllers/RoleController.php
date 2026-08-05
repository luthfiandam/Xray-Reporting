<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->authorize('viewAny', Role::class);
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'is_active' => $request->input('is_active'),
        ];

        $sort = [
            'by' => $request->input('sort_by', 'created_at'),
            'direction' => $request->input('sort_dir', 'desc'),
        ];

        $roles = $this->roleService->getPaginatedRoles($filters, $sort);
        $stats = $this->roleService->getRoleStats();

        return view('roles.index', [
            'roles' => $roles,
            'filters' => $filters,
            'stats' => $stats,
            'sort_by' => $sort['by'],
            'sort_dir' => $sort['direction'],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Role::class);
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());

            return redirect()
                ->route('roles.show', $role)
                ->with('success', "Role '{$role->name}' berhasil dibuat");
        } catch (\Exception $e) {
            Log::error('RoleController store error', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat role: ' . $e->getMessage());
        }
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);
        $role = $this->roleService->getRoleDetail($role);
        $canDelete = $this->roleService->canDeleteRole($role);

        return view('roles.show', [
            'role' => $role,
            'canDelete' => $canDelete,
        ]);
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        return view('roles.edit', ['role' => $role]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role = $this->roleService->updateRole($role, $request->validated());

            return redirect()
                ->route('roles.show', $role)
                ->with('success', "Role '{$role->name}' berhasil diperbarui");
        } catch (\Exception $e) {
            Log::error('RoleController update error', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui role: ' . $e->getMessage());
        }
    }

    public function deactivate(Role $role)
    {
        $this->authorize('deactivate', $role);

        try {
            $this->roleService->deactivateRole($role);

            return redirect()
                ->route('roles.index')
                ->with('success', "Role '{$role->name}' berhasil dinonaktifkan");
        } catch (\Exception $e) {
            Log::error('RoleController deactivate error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menonaktifkan role: ' . $e->getMessage());
        }
    }

    public function activate(Role $role)
    {
        $this->authorize('activate', $role);

        try {
            $this->roleService->activateRole($role);

            return redirect()
                ->route('roles.index')
                ->with('success', "Role '{$role->name}' berhasil diaktifkan");
        } catch (\Exception $e) {
            Log::error('RoleController activate error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengaktifkan role: ' . $e->getMessage());
        }
    }
}