<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Show page + list of feedbacks
    public function create()
    {
        $feedbacks = Feedback::with('user')
            ->orderByDesc('Date_Submitted')   // newest first
            ->orderByDesc('created_at')
            ->take(50)                        // adjust if you want
            ->get();

        return view('feedback.create', compact('feedbacks'));
    }

    // Store feedback from modal (MANY per user allowed)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating'   => ['nullable', 'integer', 'min:1', 'max:5'],
            'category' => ['required', 'string', 'max:255'],
            'message'  => ['required', 'string', 'min:5'],
        ]);

        Feedback::create([
            'Customer_ID'   => Auth::id(),             // who submitted
            'Comments'      => $validated['message'],  // legacy column
            'rating'        => $validated['rating'] ?? null,
            'category'      => $validated['category'],
            'message'       => $validated['message'],  // new column
            'Date_Submitted'=> now(),                  // required column
        ]);

        return redirect()
            ->route('feedback.create')
            ->with('success', 'Thank you for your feedback!');
    }
}
