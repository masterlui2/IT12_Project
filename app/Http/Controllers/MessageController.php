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
    'body'       => ['nullable', 'string', 'min:2', 'max:1000', 'required_without:attachment'],
    'attachment' => ['nullable', 'file', 'max:5120'], // any file up to 5MB
]);

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $attachmentName = $request->file('attachment')->getClientOriginalName();
        }


        Message::create([
            'user_id'          => Auth::id(),
            'body'             => $validated['body'] ?? ($attachmentPath ? 'Image attached' : null),
            'attachment_path'  => $attachmentPath,
            'attachment_name'  => $attachmentName,
        ]);

        return back()->with('success', 'Message sent');
    }
}