<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    public function track(){
        return view('customer.track-repair');
    }

    public function messages(){
 $latestInquiry = Inquiry::where('customer_id', Auth::id())
            ->latest()
            ->first();

        $messages = Message::with('user')
            ->latest()
            ->take(50)
            ->get()
            ->sortBy('created_at');

        return view('customer.messages', compact('latestInquiry', 'messages'));    }
}