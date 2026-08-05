<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorize('viewAny', User::class);
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'role_id' => $request->input('role_id'),
            'status' => $request->input('status'),
            'technician_code' => $request->input('technician_code'),
        ];

        $sort = [
            'by' => $request->input('sort_by', 'created_at'),
            'direction' => $request->input('sort_dir', 'desc'),
        ];

        $users = $this->userService->getPaginatedUsers($filters, $sort);
        $stats = $this->userService->getUserStats();
        $roles = $this->userService->getAvailableRoles();
        $statusOptions = $this->userService->getStatusOptions();

        return view('users.index', [
            'users' => $users,
            'filters' => $filters,
            'stats' => $stats,
            'roles' => $roles,
            'statusOptions' => $statusOptions,
            'sort_by' => $sort['by'],
            'sort_dir' => $sort['direction'],
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $roles = $this->userService->getAvailableRoles();
        $statusOptions = $this->userService->getStatusOptions();

        return view('users.create', [
            'roles' => $roles,
            'statusOptions' => $statusOptions,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());

            return redirect()
                ->route('users.show', $user)
                ->with('success', "User '{$user->name}' berhasil dibuat dengan username '{$user->username}'");
        } catch (\Exception $e) {
            Log::error('UserController store error', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user = $this->userService->getUserDetail($user);
        $statusOptions = $this->userService->getStatusOptions();

        return view('users.show', [
            'user' => $user,
            'statusOptions' => $statusOptions,
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = $this->userService->getAvailableRoles();
        $statusOptions = $this->userService->getStatusOptions();
        $canChangeRole = auth()->user()->role->name === 'Super Admin';
        $canChangeStatus = auth()->user()->can('deactivate', $user) || auth()->user()->can('suspend', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'statusOptions' => $statusOptions,
            'canChangeRole' => $canChangeRole,
            'canChangeStatus' => $canChangeStatus,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user = $this->userService->updateUser($user, $request->validated());

            return redirect()
                ->route('users.show', $user)
                ->with('success', "User '{$user->name}' berhasil diperbarui");
        } catch (\Exception $e) {
            Log::error('UserController update error', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function deactivate(User $user)
    {
        $this->authorize('deactivate', $user);

        try {
            $this->userService->deactivateUser($user);

            return redirect()
                ->route('users.index')
                ->with('success', "User '{$user->name}' berhasil dinonaktifkan");
        } catch (\Exception $e) {
            Log::error('UserController deactivate error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menonaktifkan user: ' . $e->getMessage());
        }
    }

    public function activate(User $user)
    {
        $this->authorize('activate', $user);

        try {
            $this->userService->activateUser($user);

            return redirect()
                ->route('users.index')
                ->with('success', "User '{$user->name}' berhasil diaktifkan");
        } catch (\Exception $e) {
            Log::error('UserController activate error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengaktifkan user: ' . $e->getMessage());
        }
    }

    public function suspend(User $user)
    {
        $this->authorize('suspend', $user);

        try {
            $this->userService->suspendUser($user);

            return redirect()
                ->route('users.index')
                ->with('warning', "User '{$user->name}' berhasil ditangguhkan");
        } catch (\Exception $e) {
            Log::error('UserController suspend error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menangguhkan user: ' . $e->getMessage());
        }
    }

    public function showResetPasswordForm(User $user)
    {
        $this->authorize('resetPassword', $user);
        return view('users.reset-password', ['user' => $user]);
    }

    public function resetPassword(Request $request, User $user)
    {
        $this->authorize('resetPassword', $user);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        try {
            $this->userService->resetPassword($user, $validated['password']);

            return redirect()
                ->route('users.show', $user)
                ->with('success', "Password user '{$user->name}' berhasil direset");
        } catch (\Exception $e) {
            Log::error('UserController resetPassword error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }
}