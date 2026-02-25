<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\SanitizeAndValidateInput;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
  ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    // When a GUEST hits an auth route  -> go to /login
// Ensure session and CSRF protection for web routes
        $middleware->web([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SanitizeAndValidateInput::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
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
