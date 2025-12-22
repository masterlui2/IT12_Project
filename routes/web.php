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
use App\Http\Controllers\Technician\Job\JobOrderTechnicianController;
use App\Http\Controllers\Technician\TechnicianController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\General\InquiryController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Manager\JobOrderController;
use App\Models\JobOrder;
use App\Http\Controllers\MessageController;

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
        Route::get('/inquiry', [InquiryController::class, 'create'])->name('customer.inquiry.form');
        Route::post('/inquiry', [InquiryController::class, 'store'])->name('customer.inquiry.store');
        Route::get('/inquiry/create', [InquiryController::class, 'create'])->name('customer.inquiry.create');
    // 🔹 Customer: Track Repair page
    Route::get('/track-repair', [CustomerController::class, 'track'])->name('customer.track');

    // 🔹 Customer: Messages page
    Route::get('/messages', [CustomerController::class, 'messages'])->name('customer.messages');

    });
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/quotation')->group(function() {
        Route::get('/index', [ManagerController::class, 'quotation'])->name('quotation');
        Route::post('/{quotation}/approve', [ManagerController::class,'approve'])->name('manager.quotation.approve');
        Route::post('/{quotation}/reject', [ManagerController::class,'reject'])->name('manager.quotation.reject');
        Route::get('/{id}', [QuotationController::class, 'show'])->name('manager.quotation.show');
    });
    

    Route::prefix('/inquire')->group(function(){
        Route::get('/index', [ManagerController::class, 'inquiries'])->name('inquiries');
        Route::get('/index/{id}', [ManagerController::class, 'inquireShow'])->whereNumber('id')->name('inquiries.show');
        Route::delete('/index/{id}', [ManagerController::class, 'inquireDestroy'])->whereNumber('id')->name('inquiries.destroy');
        Route::post('/{id}/assign', [ManagerController::class, 'assignTechnician'])->name('manager.inquiries.assign');
    });

    Route::prefix('/job')->group(function(){
        Route::get('/index', [JobOrderController::class, 'index'])->name('manager.job.index');
        Route::patch('/markComplete/{id}',[JobOrderController::class, 'markComplete'])->name('manager.job.markComplete');
        Route::get('/show/{id}', [JobOrderController::class, 'show'])->name('manager.job.show');
        Route::get('/show/{id}', [JobOrderController::class, 'show'])->name('manager.job.show');
        Route::post('/{id}/assign', [JobOrderController::class, 'assignTechnician'])->name('manager.job.assign');
    });

    // ⭐ Added missing components (same style, same method)
    Route::get('/technicians',[ManagerController::class, 'technicians'])->name('technicians');
    Route::post('/technicians', [ManagerController::class, 'storeTechnician'])->name('manager.technicians.store');
    Route::get('/technicians/{technician}/edit', [ManagerController::class, 'editTechnician'])
    ->name('manager.technicians.edit');

Route::put('/technicians/{technician}', [ManagerController::class, 'updateTechnician'])
    ->name('manager.technicians.update');

Route::delete('/technicians/{technician}', [ManagerController::class, 'destroyTechnician'])
    ->name('manager.technicians.destroy');
    Route::post('/job-orders', [ManagerController::class, 'storeJobOrder'])->name('manager.job-orders.store');
    Route::get('/services', [ManagerController::class, 'services'])->name('services');
    Route::get('/reports',[ManagerController::class, 'reports'])->name('manager.reports.index');
    Route::post('/reports/export',[ManagerController::class, 'exportReports'])->name('manager.reports.export');
});

Route::get('/inquiry/create', [InquiryController::class, 'create'])
        ->name('inquiry.create');

Route::post('/inquiry', [InquiryController::class, 'store'])
        ->name('inquiry.store');

Route::middleware(['auth'])->group(function () {
    // Show the inquiry creation form
      Route::get('/feedback/create', [FeedbackController::class, 'create'])
        ->name('feedback.create');
    // Handle the inquiry form submission
    Route::post('/feedback/create', [FeedbackController::class, 'store'])
        ->name('feedback.store');
 Route::get('/messages', function () {
        $user = Auth::user();

        return match ($user?->role) {
            'technician' => redirect()->route('technician.messages'),
            'customer'   => redirect()->route('customer.messages'),
            default      => redirect()->route('home'),
        };
    })->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])        ->name('messages.store');
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
        Route::get('/index', [TechnicianController::class, 'inquire'])->name('technician.inquire.index');
        Route::get('/create', [InquiryController::class, 'create'])->name('technician.inquire.create');
        Route::post('/store', [InquiryController::class, 'store'])->name('technician.inquire.store');   
        Route::post('/{id}/claim', [TechnicianController::class, 'claim'])->name('technician.inquire.claim');
        Route::get('/index/{id}', [TechnicianController::class, 'inquireShow'])->whereNumber('id')->name('technician.inquire.show');
        Route::delete('/index/{id}', [TechnicianController::class, 'inquireDestroy'])->whereNumber('id')->name('technician.inquire.destroy');
    });
    Route::get('/history', [TechnicianController::class, 'history'])->name('technician.history');
    
    Route::prefix('/quotation')->group(function (){
        Route::get('/index', [QuotationController::class, 'index'])->name('technician.quotation');
        Route::get('/new', [QuotationController::class, 'newQuotation'])->name('quotation.new');
        Route::get('/template/{id}', [QuotationController::class, 'getTemplate']);
        Route::post('/store', [QuotationController::class, 'store'])->name('quotation.store');
        Route::get('/{id}', [QuotationController::class, 'show'])->name('quotation.show');
        Route::get('/{id}/edit', [QuotationController::class, 'edit'])->name('quotation.edit');
        Route::put('/{id}', [QuotationController::class, 'update'])->name('quotation.update');
        Route::put('/send/{id}', [QuotationController::class, 'sendToManager'])->name('quotation.sendToManager');
        Route::delete('/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
        
        // PDF Routes
        Route::get('/pdf/preview', [PdfController::class, 'quotationPreview'])->name('quotation.pdf.preview'); // Static preview
        Route::get('/{id}/pdf', [PdfController::class, 'quotationPreview'])->name('quotation.pdf'); // Stream PDF
        Route::get('/{id}/pdf/download', [PdfController::class, 'quotationDownload'])->name('quotation.pdf.download'); // Download PDF
        
        // Logo upload
        Route::put('/logo', [QuotationController::class, 'uploadLogo'])->name('quotation.uploadLogo');
    });

    Route::prefix('/job')->group(function () {

        // Job Order List
        Route::get('/index', [JobOrderTechnicianController::class, 'index'])->name('technician.job.index');

        // View Job Order Details
        Route::get('/show/{id}', [JobOrderTechnicianController::class, 'show'])->name('technician.job.show');

        // Edit Job Order
        Route::get('/edit/{id}', [JobOrderTechnicianController::class, 'edit'])->name('technician.job.edit');

        Route::patch('/update/{id}', [JobOrderTechnicianController::class, 'update'])->name('technician.job.update');

        // Mark Complete (PATCH recommended)
        Route::patch('/in_progress/{id}', [JobOrderTechnicianController::class, 'in_progress'])->name('technician.job.in_progress');
    });

    Route::post('/technician/job/{id}/test-email', [JobOrderTechnicianController::class, 'testEmailToClient'])
    ->name('technician.testEmailToClient');

});
