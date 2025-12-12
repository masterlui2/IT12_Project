<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Quotation;
use App\Models\Technician;
use App\Models\JobOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ManagerController extends Controller
{
    public function dashboard(){
        return view('manager.dashboard');
    }

    public function quotation(){
        // Base query
        $quotations = Quotation::with(['technician.user','inquiry'])
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
        // Fetch inquiries
        $inquiries = Inquiry::with('technician')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Map statuses dynamically
        $statusCounts = Inquiry::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Build stats array with explicit dashboard keys
        $stats = [
            'inquiries' => [
                'unassigned' => Inquiry::whereNull('assigned_technician_id')->count(),
                'assigned'   => $statusCounts['Acknowledged'] ?? 0,
                'ongoing'    => $statusCounts['In Progress'] ?? 0,
                'completed'  => $statusCounts['Completed'] ?? 0,
                'cancelled'  => $statusCounts['Cancelled'] ?? 0,
                'scheduled'  => $statusCounts['Scheduled'] ?? 0,
                'converted'  => $statusCounts['Converted'] ?? 0,
            ],
        ];

        // Technician dropdown
        $technicians = User::where('role', 'technician')->get();

        // Unanswered inquiries older than 48 hours
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
 $technicians = Technician::with(['user', 'jobOrders' => function ($query) {
            $query->latest();
        }, 'jobOrders.quotation'])
        ->withCount('jobOrders')
        ->get();

        $approvedQuotations = Quotation::where('status', 'approved')
            ->orderByDesc('date_issued')
            ->get();

        return view('manager.technicians', compact('technicians', 'approvedQuotations'));
    }
    public function editTechnician(Technician $technician)
{
    $technician->load('user');
    return view('manager.technicians-edit', compact('technician'));
}

public function updateTechnician(Request $request, Technician $technician)
{
    $validated = $request->validate([
        'firstname'        => 'required|string|max:255',
        'lastname'         => 'required|string|max:255',
        'email'            => 'required|email|unique:users,email,' . $technician->user_id,
        'specialization'   => 'nullable|string|max:255',
        'certifications'   => 'nullable|string|max:255',
    ]);

    // update user
    $technician->user->update([
        'firstname' => $validated['firstname'],
        'lastname'  => $validated['lastname'],
        'email'     => $validated['email'],
    ]);

    // update technician
    $technician->update([
        'specialization'  => $validated['specialization'] ?? null,
        'certifications'  => $validated['certifications'] ?? null,
    ]);

    return redirect()->route('technicians')->with('status', 'Technician updated successfully.');
}

public function destroyTechnician(Technician $technician)
{
    // delete technician + linked user (optional but usually correct)
    $user = $technician->user;
    $technician->delete();
    if ($user) $user->delete();

    return redirect()->route('technicians')->with('status', 'Technician deleted successfully.');
}

    public function storeTechnician(Request $request)
    
    {
        
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'required|date',
            'password' => 'nullable|string|min:8',
            'specialization' => 'nullable|string|max:255',
            'certifications' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'birthday' => $validated['birthday'],
            'password' => Hash::make($validated['password'] ?? Str::random(12)),
            'role' => 'technician',
        ]);

        $user->technician()->create([
            'specialization' => $validated['specialization'] ?? null,
            'certifications' => $validated['certifications'] ?? null,
        ]);

        return redirect()->route('technicians')->with('status', 'Technician added successfully.');
    }

    public function storeJobOrder(Request $request)
    {
        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
            'quotation_id' => 'required|exists:quotations,id',
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:50',
            'device_type' => 'nullable|string|max:255',
            'issue_description' => 'required|string',
            'diagnostic_fee' => 'nullable|numeric|min:0',
            'materials_cost' => 'nullable|numeric|min:0',
            'professional_fee' => 'nullable|numeric|min:0',
            'downpayment' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'expected_finish_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'materials_specifications' => 'nullable|string',
            'status' => 'required|string|in:scheduled,in_progress,completed,cancelled',
        ]);

        JobOrder::create($validated);

        return redirect()->route('technicians')->with('status', 'Job order assigned to technician successfully.');
        }
    public function customers(){
        return view('manager.customers');
    }
    public function reports(){
        return view('manager.reports');
       }

    public function sales()
    {
        $stats = [
            'monthly' => [
                'total_revenue'    => '₱ 0.00',
                'avg_ticket'       => '₱ 0.00',
                'conversion_rate'  => '0%',
            ],
            'pipeline' => [
                'open_quotes' => 0,
                'won_quotes'  => 0,
            ],
        ];
        
        $recentTransactions = [];

        return view('manager.sales', compact('stats', 'recentTransactions'));
    }   
}
