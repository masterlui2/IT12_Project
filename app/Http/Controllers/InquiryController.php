<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry; // create this model if it doesn't exist

class InquiryController extends Controller

{
    // Show the inquiry form
    public function create()
    {
        return view('inquiries.create');
    }

    // Save the inquiry
    public function store(Request $request)
    {
     $data = $request->validate([
    'name'              => 'required|string|max:255',
    'contact_number'    => 'required|string|max:50',
    'device_type'       => 'required|string|max:255',
    'issue_description' => 'required|string',
    'preferred_schedule'=> 'nullable|date',
]);

Inquiry::create([
    'user_id'           => $request->user()->id,
    'name'              => $data['name'],
    'contact_number'    => $data['contact_number'],
    'device_type'       => $data['device_type'],
    'issue_description' => $data['issue_description'],
    'preferred_schedule'=> $data['preferred_schedule'],
    'status'            => 'new',
]);


        return redirect()->route('inquiry.create')
            ->with('success', 'Inquiry submitted successfully.');
    }
}
