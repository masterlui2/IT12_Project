<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Support\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ManualPasswordResetRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'proof_details' => ['nullable', 'string', 'min:20', 'max:3000'],
        ]);

        $user = User::query()->where('email', $validated['email'])->first();

        $registrationMatches = $user
            && strcasecmp($user->firstname, $validated['firstname']) === 0
            && strcasecmp($user->lastname, $validated['lastname']) === 0
            && optional($user->birthday)->toDateString() === $validated['birthday'];

        if (! $registrationMatches && blank($validated['proof_details'] ?? null)) {
            return back()
                ->withErrors([
                    'proof_details' => __('The registration details do not match our records. Please provide valid proof of identity for manual verification.'),
                ])
                ->withInput();
        }

        PasswordResetRequest::query()->create([
            'user_id' => $registrationMatches ? $user->id : null,
            'email' => $validated['email'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'birthday' => $validated['birthday'],
            'proof_details' => $validated['proof_details'] ?? null,
            'status' => 'pending',
        ]);

        AuditLogger::log(
            action: 'auth.password_reset.manual_request_created',
            meta: [
                'email' => $validated['email'],
                'registration_details_match' => $registrationMatches,
            ],
            userId: optional($request->user())->id,
        );

        return back()->with('status', __('Your password reset request has been submitted. An administrator will verify your identity and contact you once reviewed.'));
    }
}