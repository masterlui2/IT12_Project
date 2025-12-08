<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Message;
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
        ->paginate(5);                    // <- number of cards per page

    return view('feedback.create', compact('feedbacks'));
}

    // Store feedback from modal (MANY per user allowed)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating'   => ['required', 'integer', 'min:1', 'max:5'],
            'category' => ['required', 'string', 'max:255'],
            'message'  => ['required', 'string', 'min:5'],
        ]);

        $feedback = Feedback::create([
            'Customer_ID'   => Auth::id(),             // who submitted
            'Comments'      => $validated['message'],  // legacy column
            'rating'         => $validated['rating'],
            'category'      => $validated['category'],
            'message'       => $validated['message'],  // new column
            'Date_Submitted'=> now(),                  // required column
        ]);
         Message::create([
            'user_id'     => Auth::id(),
            'feedback_id' => $feedback->id,
            'subject'     => 'Customer feedback: ' . $validated['category'],
            'body'        => $validated['message'],
        ]);


        return redirect()
            ->route('feedback.create')
            ->with('success', 'Thank you for your feedback!');
    }
}
