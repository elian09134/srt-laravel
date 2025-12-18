<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UseAdminSession
{
    /**
     * Set a different session cookie name for admin routes so admin and public
     * sessions don't collide when using the same browser.
     */
    public function handle(Request $request, Closure $next)
    {
        // If request targets admin area, change session cookie name before session starts
        if ($request->is('admin') || $request->is('admin/*')) {
            $base = config('session.cookie', 'laravel_session');
            $new = $base . '_admin';
            config(['session.cookie' => $new]);
            try {
                Log::info('UseAdminSession applied', [
                    'path' => $request->path(),
                    'session_cookie' => $new,
                ]);
            } catch (\Throwable $e) {
                // ignore logging failures
            }
        }

        return $next($request);
    }
}
