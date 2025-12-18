<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
        public function handle(Request $request, Closure $next): Response
    {
        // Optimized logging - only log failures, not every request
        if (!Auth::check()) {
            Log::info('IsAdmin middleware - Unauthenticated access attempt', [
                'path' => $request->path(),
                'ip' => $request->ip(),
            ]);
            return redirect('/');
        }

        if (Auth::user()->role !== 'admin') {
            Log::warning('IsAdmin middleware - Non-admin access attempt', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role,
                'path' => $request->path(),
            ]);
            return redirect('/');
        }

        return $next($request);
    }
}