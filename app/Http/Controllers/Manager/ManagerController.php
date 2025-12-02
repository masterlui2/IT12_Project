<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function dashboard(){
        return view('manager.dashboard');
    }

    public function quotation(){
        // Base query
        $quotations = Quotation::with('technician.user')
            ->whereIn('status',['pending','approved','rejected'])
            ->orderByDesc('date_issued')
            ->paginate(10);

        // Dashboard cards
        $pendingCount = Quotation::where('status', 'pending')->count();

        $approvedThisWeek = Quotation::where('status', 'approved')
            ->whereBetween('date_issued', [
                Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()
            ])->count();

        $pendingValue = Quotation::where('status', 'pending')->sum('grand_total');

        return view('manager.quotation', compact(
            'quotations', 'pendingCount', 'approvedThisWeek', 'pendingValue'
        ));
    }

    public function inquiries()
    {
        // Fetch inquiries with assigned technician
        $inquiries = Inquiry::with('assignedTechnician')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Stats - accurate count using separate queries
        $stats = [
            'inquiries' => [
                'unassigned' => Inquiry::whereNull('assigned_technician_id')->count(),

                // Technician has been assigned (status 'Acknowledged')
                'assigned'   => Inquiry::where('status', 'Acknowledged')->count(),

                // Work in progress, technician actively assessing or repairing
                'ongoing'    => Inquiry::where('status', 'In Progress')->count(),

                // Successfully finished
                'completed'  => Inquiry::where('status', 'Completed')->count(),

                // Cancelled by customer or manager
                'cancelled'  => Inquiry::where('status', 'Cancelled')->count(),
            ],
        ];

        // Fetch technicians list for assignment dropdown
        $technicians = User::where('role', 'technician')->get();

        // Identify inquiries that are older than 48 hours without reply
        $unanswered = Inquiry::whereNull('assigned_technician_id')
            ->where('created_at', '<', Carbon::now()->subHours(48))
            ->count();

        return view('manager.inquiries', compact('inquiries', 'stats', 'technicians', 'unanswered'));
    }

    public function approve(Quotation $quotation)
    {
        $quotation->update(['status' => 'approved', 'approved_by' => Auth::user()->id]);
        return back()->with('success','Quotation approved successfully.');
    }

    public function reject(Quotation $quotation)
    {
        $quotation->update(['status' => 'rejected', 'approved_by' => Auth::user()->id]);
        return back()->with('success','Quotation rejected.');
    }

    public function assignTechnician(Request $request, $inquiryId)
    {
        $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $inquiry = Inquiry::findOrFail($inquiryId);
        $inquiry->assigned_technician_id = $request->technician_id;
        $inquiry->status = 'Acknowledged';
        $inquiry->save();

        return redirect()->route('inquiries')
            ->with('status', 'Technician assigned to inquiry INQ-' . str_pad($inquiry->id, 8, '0', STR_PAD_LEFT));
    }
    
    public function inquireShow(int $id){
        $inq = Inquiry::findOrFail($id);
        return redirect()->route('manager.inquiries')
            ->with('status', 'Viewing inquiry INQ-'.$inq->id);
    }

    public function inquireDestroy(int $id){
        $inq = Inquiry::findOrFail($id);
        $inq->delete();
        return redirect()->route('manager.inquiries')
            ->with('status', 'Inquiry INQ-'.$id.' deleted');
    }

    public function services(){
        return view('manager.services');
    }
    public function technicians(){
        return view('manager.technicians');
    }
    public function customers(){
        return view('manager.customers');
    }
    public function reports(){
        return view('manager.reports');
    }    
}
