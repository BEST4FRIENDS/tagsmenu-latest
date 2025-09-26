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
        
        // Fügen Sie alle Ihre Middleware-Aliase hier in dieses eine Array ein.
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\CheckSuperadmin::class,
            'subscribed' => \App\Http\Middleware\CheckSubscribed::class, // <-- DIESE ZEILE WURDE HINZUGEFÜGT
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();