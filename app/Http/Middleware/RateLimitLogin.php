<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimitLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limit login attempts
        $email = $request->input('email');
        $key = 'login_attempts_' . $email;
        $maxAttempts = 5;
        $lockoutMinutes = 15;

        // Check if user is locked out
        if (Cache::has($key) && Cache::get($key) >= $maxAttempts) {
            \Log::warning('Too many login attempts', [
                'email' => $email,
                'ip' => $request->ip(),
            ]);

            return redirect()->back()
                ->with('error', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$lockoutMinutes} menit.");
        }

        $response = $next($request);

        // Increment attempt counter if login failed (401 status)
        if ($response->status() === 401 || $response->status() === 419) {
            $attempts = Cache::get($key, 0) + 1;
            Cache::put($key, $attempts, now()->addMinutes($lockoutMinutes));
        } else if ($response->status() === 302 || $response->status() === 200) {
            // Clear attempts if login successful
            Cache::forget($key);
        }

        return $response;
    }
}