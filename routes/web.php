<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/password-reset', [AuthController::class, 'showPasswordResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword']);
});

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard (for all authenticated users)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// API Auth Route (check authentication status)
Route::get('/api/auth/check', [AuthController::class, 'checkAuth']);