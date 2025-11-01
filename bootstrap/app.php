<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocaleMiddleware; // Importieren Sie die neue Middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Fügen Sie die SetLocaleMiddleware zur 'web' Gruppe hinzu.
        $middleware->web(append: [
            SetLocaleMiddleware::class,
        ]);

        // Fügen Sie alle Ihre Middleware-Aliase hier in dieses eine Array ein.
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\CheckSuperadmin::class,
            'subscribed' => \App\Http\Middleware\CheckSubscribed::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();