<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        // Attempt login
        if ($this->authService->login($credentials)) {
            $request->session()->regenerate();

            \Log::info('User login successful', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang ' . auth()->user()->name);
        }

        \Log::warning('Login attempt failed', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
        ]);

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $userName = auth()->user()->name;
        $userId = auth()->id();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        \Log::info('User logout', [
            'user_id' => $userId,
            'user_name' => $userName,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Show password reset form
     */
    public function showPasswordResetForm()
    {
        return view('auth.password-reset');
    }

    /**
     * Handle password reset request
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!auth()->check() && !$this->authService->resetPassword($request->only('email', 'current_password', 'new_password'))) {
            return redirect()->back()
                ->with('error', 'Password saat ini salah');
        }

        \Log::info('Password reset successful', [
            'user_id' => auth()->id(),
            'email' => auth()->user()->email,
        ]);

        return redirect()->route('login')
            ->with('success', 'Password Anda telah berhasil diubah. Silakan login kembali');
    }

    /**
     * Check authentication status (API endpoint)
     */
    public function checkAuth()
    {
        if (auth()->check()) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'role' => auth()->user()->role->name,
                    'status' => auth()->user()->status,
                ],
            ]);
        }

        return response()->json(['authenticated' => false], 401);
    }
}