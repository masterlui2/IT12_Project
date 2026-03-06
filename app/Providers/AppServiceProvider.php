<?php

namespace App\Providers;

use App\Models\Quotation;
use App\Models\User;
use App\Observers\QuotationObserver;
use App\Observers\UserObserver;
use App\Support\AuditLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(12)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        // Force HTTPS in production or ngrok
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        if (request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        // Register model observers
        User::observe(UserObserver::class);
        Quotation::observe(QuotationObserver::class);

        Event::listen(Failed::class, function (Failed $event): void {
            $usernameField = Fortify::username();
            $identifier = $event->credentials[$usernameField] ?? null;

            AuditLogger::logAuthAttempt('auth.login.failed', $identifier, 'invalid_credentials', null, [
                'guard' => $event->guard,
                'method' => 'fortify_password',
            ]);
        });

        Event::listen(Lockout::class, function (Lockout $event): void {
            $usernameField = Fortify::username();

            AuditLogger::logAuthAttempt(
                'auth.login.failed',
                $event->request->input($usernameField),
                'throttled',
                null,
                [
                    'method' => 'fortify_password',
                    'username_field' => $usernameField,
                ]
            );
        });

        Event::listen(Login::class, function (Login $event): void {
            $identifier = $event->user?->{Fortify::username()} ?? $event->user?->email;

            AuditLogger::logAuthAttempt('auth.login.succeeded', $identifier, 'authenticated', $event->user?->id, [
                'guard' => $event->guard,
            ]);
        });
    }
}