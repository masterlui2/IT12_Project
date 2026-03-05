<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordApiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink([
            'email' => $validated['email'],
        ]);

        AuditLogger::log(
            action: 'auth.password_reset_link_requested',
            meta: [
                'email' => $validated['email'],
                'status' => $status,
            ],
            userId: optional($request->user())->id,
        );

        return response()->json([
            'message' => __($status),
            'sent' => $status === Password::RESET_LINK_SENT,
        ]);
    }
}