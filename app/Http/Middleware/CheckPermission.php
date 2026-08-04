<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user has the required permission
        if (!$this->hasPermission(auth()->user(), $permission)) {
            \Log::warning('Unauthorized permission access attempt', [
                'user_id' => auth()->id(),
                'required_permission' => $permission,
                'path' => $request->path(),
            ]);

            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }

    /**
     * Check if user has the required permission
     */
    private function hasPermission($user, $permission): bool
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
                'work_order.reopen',
                'checklist.view',
                'measurement.view',
                'evidence.view',
                'report.view',
                'report.generate',
            ],
            'Super Admin' => [
                // All permissions
            ],
        ];

        $userPermissions = $rolePermissions[$user->role->name] ?? [];

        return in_array($permission, $userPermissions);
    }
}