<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordApiController;

Route::middleware('throttle:6,1')->post('/forgot-password', ForgotPasswordApiController::class)
    ->name('api.forgot-password');
Route::middleware('api')->get('/test', function () {
    return response()->json(['message' => 'API is working']);
});