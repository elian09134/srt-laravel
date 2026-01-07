<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'block.suspicious' => \App\Http\Middleware\BlockSuspiciousIps::class,
    ]);
    
    // IP blocking middleware temporarily disabled - causing 500 errors with cache
    // $middleware->web(append: [
    //     \App\Http\Middleware\BlockSuspiciousIps::class,
    // ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
