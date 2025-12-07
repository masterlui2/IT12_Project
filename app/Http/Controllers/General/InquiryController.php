<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Models\Inquiry; // create this model if it doesn't exist
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller

{
    // Show the inquiry form
    public function create()
    {
        if(Auth::check()){
            return match(Auth::user()->role){
                'technician'   => view('technician.contents.inquiries.create'),
                'customer'     => view('customer.inquiries.create'),
                default        => view('customer.inquiries.create')
            };
        }
    }

    // Save the inquiry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email',
            'contact_number'     => 'required|string|max:20',
            'service_location'   => 'required|string',
            'category'           => 'required|string',
            'device_type'        => 'nullable|string|max:255',
            'device_details'     => 'nullable|string|max:255',
            'issue_description'  => 'required|string|max:2000',
            'urgency'            => 'required|in:Normal,Urgent,Flexible',
            'preferred_schedule' => 'nullable|date',
            'photo'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'referral_source'    => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('inquiry-photos', 'public');
            $validated['photo_path'] = $path;
        }
           // Map device_type to device_details when not explicitly provided to
        // satisfy older database schemas that expect the column.
        $validated['device_type'] = $validated['device_type']
            ?? ($validated['device_details'] ?? null);

        // Default status
        $validated['status'] = 'Pending';

        if (Auth::check()) {
            $user = Auth::user();
            $validated['user_id'] = $user->id;

            // 🔹 Customer submitting an inquiry
            if ($user->role === 'customer') {
                $validated['customer_id'] = $user->id;
            }

            // 🔹 Technician submitting an inquiry (self‑assigned diagnostic)
            elseif ($user->role === 'technician') {
                $technician = $user->technician;

                if ($technician) {
                    $validated['assigned_technician_id'] = $technician->id;
                    $validated['status'] = 'Acknowledged';  // starts directly as acknowledged/claimed
                }
            }
            } else {
            $validated['user_id'] = null;
        }

        Inquiry::create($validated);

        return redirect()->back()->with('success', 'Inquiry submitted successfully!');
    }

    public function index()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->get();
        return view('manager.inquiries', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        // create this view: resources/views/manager/inquiry-show.blade.php (or whatever name you prefer)
        return view('manager.inquiries', compact('inquiry'));
    }
    

}