<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Quotation;
use App\Observers\UserObserver;
use App\Observers\QuotationObserver;

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
        // Force HTTPS in production or ngrok
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        if (request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        // Register model observers
        User::observe(UserObserver::class);
        Quotation::observe(QuotationObserver::class);   // 👈 add this line
    }
}
