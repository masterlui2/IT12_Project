<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
 ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'manager' => \App\Http\Middleware\ManagerMiddleware::class,
    ]);

    // When a GUEST hits an auth route  -> go to /login
    // When a LOGGED-IN user hits /login or /register again -> go to /
    $middleware->redirectTo(
        guests: '/login',
        users: '/',
    );
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
