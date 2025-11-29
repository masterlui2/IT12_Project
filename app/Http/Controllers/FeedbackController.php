<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * Show the feedback form.
     */
    public function create(): View
    {
        return view('feedback.create');
    }

    /**
     * Store a new feedback message for the authenticated user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'rating'  => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'rating'  => $validated['rating'] ?? null,
        ]);

        return redirect()
            ->route('feedback.create')
            ->with('status', 'Thank you for sharing your feedback!');
    }
}