<?php

use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Technician\Quotation\QuotationController;
use App\Http\Controllers\Technician\TechnicianController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\General\InquiryController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\FeedbackController;

// Generic landing
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'technician' => redirect()->route('technician.dashboard'),
            'manager'    => redirect()->route('dashboard'),
            default      => view('layouts.welcome'),
        };
    }

    return view('layouts.welcome');
})->name('home');

// Customer area
Route::middleware(['auth', 'verified', 'role:customer'])
    ->prefix('customer')
    ->group(function () {
        Route::get('/dashboard', fn () => view('customer.welcome'))->name('customer.welcome');
        Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
        Route::get('/inquiry/create', [InquiryController::class, 'create'])->name('inquiry.create');
    // 🔹 Customer: Track Repair page
    Route::get('/track-repair', [CustomerController::class, 'track'])->name('customer.track');

    // 🔹 Customer: Messages page
    Route::get('/messages', [CustomerController::class, 'messages'])->name('customer.messages');

    });
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/quotation', [ManagerController::class, 'quotation'])->name('quotation');

    Route::prefix('/inquire')->group(function(){
        Route::get('/index', [ManagerController::class, 'inquiries'])->name('inquiries');
        Route::get('/index/{id}', [TechnicianController::class, 'inquireShow'])->whereNumber('id')->name('inquiries.show');
        Route::delete('/index/{id}', [TechnicianController::class, 'inquireDestroy'])->whereNumber('id')->name('inquiries.destroy');
    });

    // ⭐ Added missing components (same style, same method)
    Route::get('/customers', [ManagerController::class, 'customers'])->name('customers');
    Route::get('/technicians',[ManagerController::class, 'technicians'])->name('technicians');
    Route::get('/services', [ManagerController::class, 'services'])->name('services');
    Route::get('/reports',[ManagerController::class, 'reports'])->name('reports');
});
Route::middleware(['auth'])->group(function () {
    // Show the inquiry creation form

    // Handle the inquiry form submission
    Route::post('/inquiry', [InquiryController::class, 'store'])
        ->name('inquiry.store');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])
        ->name('feedback.create');

    Route::post('/feedback', [FeedbackController::class, 'store'])
        ->name('feedback.store');
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

Route::middleware(['auth','verified','role:technician'])->prefix('/technician')->group(function () {
    Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('technician.dashboard');
    Route::get('/messages', [TechnicianController::class, 'messages'])->name('technician.messages');
    Route::get('/reporting', [TechnicianController::class, 'reporting'])->name('technician.reporting');
    
    Route::prefix('/inquire')->group(function(){
        Route::get('/index', [TechnicianController::class, 'inquire'])->name('technician.inquire');
        Route::get('/create', [InquiryController::class, 'create'])->name('technician.inquire.create');
        Route::post('/store', [InquiryController::class, 'store'])->name('technician.inquire.store');
        Route::get('/index/{id}', [TechnicianController::class, 'inquireShow'])->whereNumber('id')->name('technician.inquire.show');
        Route::delete('/index/{id}', [TechnicianController::class, 'inquireDestroy'])->whereNumber('id')->name('technician.inquire.destroy');
    });
    Route::get('/history', [TechnicianController::class, 'history'])->name('technician.history');
    
    Route::prefix('/quotation')->group(function (){
        Route::get('/index', [QuotationController::class, 'index'])->name('technician.quotation');
        Route::get('/new', [QuotationController::class, 'newQuotation'])->name('quotation.new');
        Route::post('/store', [QuotationController::class, 'store'])->name('quotation.store');
        Route::get('/{id}', [QuotationController::class, 'show'])->name('quotation.show');
        Route::get('/{id}/edit', [QuotationController::class, 'edit'])->name('quotation.edit');
        Route::put('/{id}', [QuotationController::class, 'update'])->name('quotation.update');
        Route::delete('/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
        
        // PDF Routes
        Route::get('/pdf/preview', [PdfController::class, 'quotationPreview'])->name('quotation.pdf.preview'); // Static preview
        Route::get('/{id}/pdf', [PdfController::class, 'quotationPreview'])->name('quotation.pdf'); // Stream PDF
        Route::get('/{id}/pdf/download', [PdfController::class, 'quotationDownload'])->name('quotation.pdf.download'); // Download PDF
        
        // Logo upload
        Route::put('/logo', [QuotationController::class, 'uploadLogo'])->name('quotation.uploadLogo');
    });
});