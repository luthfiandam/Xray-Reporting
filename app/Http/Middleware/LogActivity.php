<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log activity hanya untuk authenticated users dan methods yang penting
        if (auth()->check() && $this->shouldLog($request)) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Check if request should be logged
     */
    private function shouldLog(Request $request): bool
    {
        // Log POST, PUT, DELETE, PATCH requests
        return in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH']);
    }

    /**
     * Log the activity
     */
    private function logActivity(Request $request, Response $response): void
    {
        $logData = [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'method' => $request->method(),
            'path' => $request->path(),
            'url' => $request->url(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status_code' => $response->status(),
            'timestamp' => now()->toDateTimeString(),
        ];

        // Log based on status code
        if ($response->status() >= 400) {
            \Log::warning('Activity logged with error status', $logData);
        } else {
            \Log::info('User activity logged', $logData);
        }
    }
}