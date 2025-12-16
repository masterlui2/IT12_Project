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
    public function dashboard(Request $request)
    {
        $range = $request->input('range', 'today');
        $now   = Carbon::now();

        switch ($range) {
            case 'week':
                $start = $now->copy()->startOfWeek();
                break;
            case 'month':
                $start = $now->copy()->startOfMonth();
                break;
            case 'quarter':
                $start = $now->copy()->startOfQuarter();
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                break;
            default:
                $start = $now->copy()->startOfDay();
        }

        $end = $now;

        $inquiriesRange = Inquiry::whereBetween('created_at', [$start, $end]);
        $quotationsRange = Quotation::whereBetween('created_at', [$start, $end]);
        $jobsRange = JobOrder::whereBetween('created_at', [$start, $end]);

        $recentJobs = JobOrder::with(['quotation.customer', 'quotation.inquiry', 'technician.user'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function (JobOrder $job) {
                $customer = optional($job->quotation?->customer);
                $technicianUser = optional($job->technician?->user);
                $inquiry = $job->quotation?->inquiry;

                return [
                    'id'         => $job->id,
                    'customer'   => trim($customer?->firstname . ' ' . $customer?->lastname) ?: 'Customer',
                    'device'     => $inquiry?->device_type ?? $inquiry?->issue_description ?? '—',
                    'technician' => trim($technicianUser?->firstname . ' ' . $technicianUser?->lastname) ?: 'Unassigned',
                    'status'     => $job->status ?? 'pending',
                    'quoted'     => $job->quotation?->grand_total ?? 0,
                ];
            })
            ->toArray();

        $totalQuotations = (clone $quotationsRange)->count();

        $stats = [
            'inquiries' => [
                'total'     => (clone $inquiriesRange)->count(),
                'converted' => (clone $inquiriesRange)->where('status', 'Converted')->count(),
            ],
            'quotations' => [
                'sent'           => $totalQuotations,
                'approved'       => (clone $quotationsRange)->where('status', 'approved')->count(),
                'rejected'       => (clone $quotationsRange)->where('status', 'rejected')->count(),
                'approval_rate'  => $totalQuotations > 0
                    ? round(((clone $quotationsRange)->where('status', 'approved')->count() / $totalQuotations) * 100, 1)
                    : null,
            ],
            'jobs' => [
                'total'     => (clone $jobsRange)->count(),
                'active'    => (clone $jobsRange)->whereIn('status', ['scheduled', 'in_progress'])->count(),
                'ongoing'   => (clone $jobsRange)->where('status', 'in_progress')->count(),
                'pending'   => (clone $jobsRange)->where('status', 'pending')->count(),
                'completed' => (clone $jobsRange)->where('status', 'completed')->count(),
            ],
            'revenue' => [
                'approved_total' => Quotation::where('status', 'approved')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('grand_total'),
            ],
            'recent_jobs' => $recentJobs,
        ];

        return view('manager.dashboard', compact('stats', 'range'));
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

    public function inquiries(Request $request)    {
         $filters = [
            'search'      => $request->input('search'),
            'status'      => $request->input('status'),
            'technician'  => $request->input('technician'),
        ];

        $inquiriesQuery = Inquiry::with(['technician.user', 'customer'])
            ->orderByDesc('created_at');

        if ($filters['search']) {
            $search = $filters['search'];
            $numericId = (int) str_replace(['INQ-', 'inq-', ' '], '', $search);

            $inquiriesQuery->where(function ($query) use ($search, $numericId) {
                $query->when($numericId > 0, fn ($q) => $q->orWhere('id', $numericId))
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('service_location', 'like', "%{$search}%")
                    ->orWhere('issue_description', 'like', "%{$search}%");
            });
        }

        if ($filters['status']) {
            $inquiriesQuery->where('status', $filters['status']);
        }

        if ($filters['technician']) {
            $inquiriesQuery->where('assigned_technician_id', $filters['technician']);
        }
       $inquiries = $inquiriesQuery
            ->paginate(10)
            ->appends($filters);

        // Map statuses dynamically
        $statusCounts = Inquiry::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Build stats array with explicit dashboard keys
        $stats = [
            'inquiries' => [
                'unassigned' => Inquiry::whereNull('assigned_technician_id')->count(),
                'pending'    => $statusCounts['Pending'] ?? 0,
                'assigned'   => $statusCounts['Acknowledged'] ?? 0,
                'ongoing'    => $statusCounts['In Progress'] ?? 0,
                'completed'  => $statusCounts['Completed'] ?? 0,
                'cancelled'  => $statusCounts['Cancelled'] ?? 0,
                'scheduled'  => $statusCounts['Scheduled'] ?? 0,
                'converted'  => $statusCounts['Converted'] ?? 0,
            ],
        ];

        // Technician dropdown
        $technicians = Technician::with('user')->get();
        // Unanswered inquiries older than 48 hours
        $unanswered = Inquiry::whereNull('assigned_technician_id')
            ->where('created_at', '<', Carbon::now()->subHours(48))
            ->count();

        return view('manager.inquiries', compact('inquiries', 'stats', 'technicians', 'unanswered', 'filters'));    }

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
    

    public function customers()
    {
        return view('manager.customers');
    }
    public function reports()
    {
        $now = Carbon::now();
        
        // Monetary stats
        $approvedThisMonth = Quotation::where('status', 'approved')
            ->whereMonth('date_issued', $now->month)
            ->whereYear('date_issued', $now->year)
            ->sum('grand_total');

        $averageQuotation = Quotation::avg('grand_total') ?? 0;
        $diagnosticFees   = Quotation::sum('diagnostic_fee');

        // Volume metrics
        $totalQuotations = Quotation::count();
        $approvedCount   = Quotation::where('status', 'approved')->count();
        $pendingCount    = Quotation::where('status', 'pending')->count();
        $rejectedCount   = Quotation::where('status', 'rejected')->count();

        $approvalRate = $totalQuotations > 0
            ? round(($approvedCount / $totalQuotations) * 100, 1)
            : 0;

        $stats = [
            'reports' => [
                'quotation_sales_month' => $approvedThisMonth,
                'average_quotation'     => $averageQuotation,
                'diagnostic_fees'       => $diagnosticFees,
                'approval_rate'         => $approvalRate,
            ],
            'counts' => [
                'total'    => $totalQuotations,
                'approved' => $approvedCount,
                'pending'  => $pendingCount,
                'rejected' => $rejectedCount,
            ],
        ];

       $reportRows = Quotation::with(['customer', 'inquiry'])
    ->orderByDesc('date_issued')
    ->paginate(12);

        return view('manager.reports', compact('stats', 'reportRows'));
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
