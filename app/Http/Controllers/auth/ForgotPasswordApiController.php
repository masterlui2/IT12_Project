<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordApiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        AuditLogger::log(
            action: 'auth.password_reset_link_requested',
            meta: [
                'email' => $validated['email'],
                'status' => 'manual_admin_verification_required',
            ],
            userId: optional($request->user())->id,
        );

        return response()->json([

            'message' => __('For security, password reset requests are processed manually. Please contact an administrator for identity verification.'),
            'sent' => false,
            'requires_admin' => true,
        ]);
    }
}
