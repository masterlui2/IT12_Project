<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
class TechnicianController extends Controller
{
    public function dashboard(){
        return view('technician.contents.dashboard');
    }

    public function messages(){
        return view('technician.contents.messages');
    }

    public function reporting(){
        return view('technician.contents.reporting');
    }

    public function inquire(){
        $inquiries = Inquiry::orderByDesc('created_at')->paginate(10);
        return view('technician.contents.inquiries.index', compact('inquiries'));
    }

    public function claim($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Prevent re-claiming if already assigned
        if ($inquiry->assigned_technician_id) {
            return redirect()->back()->with('error', 'This inquiry is already claimed.');
        }

        $inquiry->assigned_technician_id = Auth::user()->id;
        $inquiry->status = 'Acknowledged'; // assuming your ENUM workflow
        $inquiry->save();

        return redirect()->route('technician.inquire.index')
        ->with('success', 'Inquiry INQ-' . str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) . ' claimed successfully.');

    }

    public function inquireShow(int $id)
    {
        // Fetch inquiry with necessary relationships
        $inquiry = Inquiry::with('assignedTechnician', 'customer')->findOrFail($id);

        // Render technician detail view
        return view('technician.contents.inquiries.show', compact('inquiry'));
    }

    public function inquireDestroy(int $id){
        $inq = Inquiry::findOrFail($id);
        $inq->delete();
        return redirect()->route('technician.inquire.index')
            ->with('status', 'Inquiry INQ-'.$id.' deleted');
    }

    public function history(){
        return view('technician.contents.history');
    }
}
