<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            Nuwave\Lighthouse\Http\Middleware\AttemptAuthentication::class
        ]);
        $middleware->append([
            App\Http\Middleware\Cors::class
        ]);
        $middleware->validateCsrfTokens(except: [
            'graphql'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
