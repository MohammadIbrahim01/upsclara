<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip API key check if not required
        if (!config('app.require_api_key', false)) {
            return $next($request);
        }

        $apiKey = $this->extractApiKey($request);

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key is required',
                'error' => 'Missing API key in request headers'
            ], 401);
        }

        if (!$this->isValidApiKey($apiKey)) {
            return response()->json([
                'message' => 'Invalid API key',
                'error' => 'The provided API key is not valid'
            ], 401);
        }

        // Optional: Log API usage
        $this->logApiUsage($request, $apiKey);

        return $next($request);
    }

    /**
     * Extract API key from request
     */
    private function extractApiKey(Request $request): ?string
    {
        // Try X-API-Key header first
        if ($apiKey = $request->header('X-API-Key')) {
            return $apiKey;
        }

        // Try Bearer token
        if ($bearerToken = $request->bearerToken()) {
            return $bearerToken;
        }

        // Try Authorization header (for non-Bearer formats)
        if ($authHeader = $request->header('Authorization')) {
            // Skip if it's a Bearer token (already handled above)
            if (!str_starts_with($authHeader, 'Bearer ')) {
                return $authHeader;
            }
        }

        // Try query parameter
        if ($queryKey = $request->query('api_key')) {
            return $queryKey;
        }

        return null;
    }

    /**
     * Validate the API key
     */
    private function isValidApiKey(string $apiKey): bool
    {
        // Method 1: Single API key from config
        $configKey = config('app.api_key');
        if ($configKey && hash_equals($configKey, $apiKey)) {
            return true;
        }

        // Method 2: Multiple API keys (for different clients)
        $validKeys = config('app.api_keys', []);
        return in_array($apiKey, $validKeys, true);
    }

    /**
     * Log API usage for monitoring
     */
    private function logApiUsage(Request $request, string $apiKey): void
    {
        if (config('app.log_api_usage', false)) {
            Log::info('API Key Usage', [
                'api_key' => substr($apiKey, 0, 8) . '...',
                'ip' => $request->ip(),
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);
        }
    }
}
