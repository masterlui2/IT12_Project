<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Technician\TechnicianController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth', 'verified', 'manager'])->group(function () {
    Route::get('/dashboard', fn () => view('manager.dashboard'))->name('dashboard');
    Route::get('/quotation', fn () => view('manager.quotation'))->name('quotation');
    Route::get('/inquiries', fn () => view('manager.inquiries'))->name('inquiries');

    // ⭐ Added missing components (same style, same method)
    Route::get('/customers', fn () => view('manager.customers'))->name('customers');
    Route::get('/technicians', fn () => view('manager.technicians'))->name('technicians');
    Route::get('/services', fn () => view('manager.services'))->name('services');
    Route::get('/reports', fn () => view('manager.reports'))->name('reports');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});



// Google
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Facebook
Route::get('/auth/facebook/redirect', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook.redirect');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

// Legal pages
Route::get('/terms-of-service', [SocialAuthController::class, 'terms'])->name('terms.service');
Route::get('/privacy-policy', [SocialAuthController::class, 'privacy'])->name('privacy.policy');

Route::prefix('/admin')->group(function (){
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/system-management',[AdminController::class, 'systemManagement'])->name('admin.systemManagement');
    Route::get('/user-access',[AdminController::class, 'userAccess'])->name('admin.userAccess');
    Route::get('/activity-logs',[AdminController::class, 'activity'])->name('admin.activity');
    Route::get('/analytics',[AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/devtools',[AdminController::class, 'developerTools'])->name('admin.developerTools');
    Route::get('/documentation',[AdminController::class, 'documentation'])->name('admin.documentation');
});

Route::prefix('/technician')->group(function () {
    Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('technician.dashboard');
    Route::get('/quotation', [TechnicianController::class, 'quotation'])->name('technician.quotation');
    Route::get('/messages', [TechnicianController::class, 'messages'])->name('technician.messages');
    Route::get('/reporting', [TechnicianController::class, 'reporting'])->name('technician.reporting');
    Route::get('/inquire', [TechnicianController::class, 'inquire'])->name('technician.inquire');
    Route::get('/history', [TechnicianController::class, 'history'])->name('technician.history');
});