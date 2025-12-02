<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use App\Models\Feedback;
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
        if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    
    // Or specifically for ngrok
    if (request()->header('X-Forwarded-Proto') === 'https') {
        URL::forceScheme('https');
    }
    

        User::observe(UserObserver::class);
         // Share recent feedback with any view that includes the testimonials partial
        View::composer('customer.about-feedback', function ($view) {
            $recentFeedback = Feedback::with('user')
                ->orderByDesc('Date_Submitted')
                ->orderByDesc('created_at')
                ->take(3)
                ->get();

            $view->with('feedbacks', $recentFeedback);
        });
    }
}
