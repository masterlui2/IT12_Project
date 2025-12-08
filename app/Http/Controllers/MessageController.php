<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'body'    => $validated['body'],
        ]);

        return back()->with('success', 'Message sent');
    }
}