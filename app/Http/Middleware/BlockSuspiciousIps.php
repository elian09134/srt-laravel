<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BlockSuspiciousIps
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $cacheKey = "blocked_ip:{$ip}";
            
            // Check if IP is blocked
            if (Cache::has($cacheKey)) {
                Log::warning("Blocked IP attempted access: {$ip}");
                abort(403, 'Your IP has been temporarily blocked due to suspicious activity.');
            }
            
            // Track request frequency
            $requestKey = "ip_requests:{$ip}";
            $requests = Cache::get($requestKey, 0);
            
            // If more than 100 requests in 1 minute, block for 10 minutes
            if ($requests > 100) {
                Cache::put($cacheKey, true, now()->addMinutes(10));
                Log::warning("IP blocked for excessive requests: {$ip}");
                abort(429, 'Too many requests. Please try again later.');
            }
            
            // Increment request counter
            Cache::put($requestKey, $requests + 1, now()->addMinute());
        } catch (\Exception $e) {
            // If cache fails, log error but don't block the request
            Log::error("BlockSuspiciousIps middleware error: " . $e->getMessage());
        }
        
        return $next($request);
    }
}
