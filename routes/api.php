<?php

use App\Http\Controllers\Auth\ForgotPasswordApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:6,1')->post('/forgot-password', ForgotPasswordApiController::class)
    ->name('api.forgot-password');