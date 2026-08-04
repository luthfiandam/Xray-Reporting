<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogLastActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Update last activity timestamp setiap request
            auth()->user()->update([
                'last_login_at' => now(),
            ]);
        }

        return $next($request);
    }
}