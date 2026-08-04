<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user status is active
        if (auth()->user()->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan');
        }

        // Check if user has one of the required roles
        if (!in_array(auth()->user()->role->name, $roles)) {
            \Log::warning('Unauthorized role access attempt', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role->name,
                'required_roles' => $roles,
                'path' => $request->path(),
            ]);

            return response()->view('errors.403', [], 403);
        }

        // Update last login timestamp
        auth()->user()->update(['last_login_at' => now()]);

        return $next($request);
    }
}