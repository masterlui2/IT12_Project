<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class InquiryController extends Controller
{
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
