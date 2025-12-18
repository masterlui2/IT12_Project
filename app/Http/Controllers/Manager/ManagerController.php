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
    
    // ===== JOB ORDER REVENUE (Real Sales) =====
    $jobOrdersThisMonth = JobOrder::whereMonth('created_at', $now->month)
        ->whereYear('created_at', $now->year)
        ->sum('subtotal');
    
    $completedJobsRevenue = JobOrder::where('status', 'completed')
        ->sum('subtotal');
    
    $downpaymentsReceived = JobOrder::where('status', 'completed')
        ->sum('downpayment');
    
    $remainingBalance = JobOrder::where('status', 'completed')
        ->sum('total_amount');
    
    // ===== DIAGNOSTIC FEES (Upfront Collection) =====
    $diagnosticFeesThisMonth = Quotation::whereMonth('date_issued', $now->month)
        ->whereYear('date_issued', $now->year)
        ->sum('diagnostic_fee');
    
    $totalDiagnosticFees = Quotation::sum('diagnostic_fee');
    
    // ===== EXPECTED DOWNPAYMENTS (50% from approved quotations not yet converted to jobs) =====
    $approvedQuotationsNotConverted = Quotation::where('status', 'approved')
        ->whereDoesntHave('jobOrders') // Quotations that haven't been converted to job orders yet
        ->sum('grand_total');
    
    $expectedDownpayments = $approvedQuotationsNotConverted * 0.50;
    
    // ===== APPROVAL METRICS =====
    $totalQuotations = Quotation::count();
    $approvedCount = Quotation::where('status', 'approved')->count();
    $pendingCount = Quotation::where('status', 'pending')->count();
    $rejectedCount = Quotation::where('status', 'rejected')->count();
    
    $approvalRate = $totalQuotations > 0
        ? round(($approvedCount / $totalQuotations) * 100, 1)
        : 0;
    
    // ===== TOTAL REVENUE CALCULATION =====
    // Total Revenue = Completed Job Orders + Diagnostic Fees Collected
    $totalRevenue = $completedJobsRevenue + $totalDiagnosticFees;
    
    $stats = [
        'reports' => [
            // Main revenue metrics (from job orders)
            'job_order_sales_month' => $jobOrdersThisMonth, // Job orders created this month
            'completed_jobs_revenue' => $completedJobsRevenue, // Total from completed jobs
            'downpayments_received' => $downpaymentsReceived, // 50% already collected
            'remaining_balance' => $remainingBalance, // 50% still to collect
            
            // Diagnostic fees (upfront collections)
            'diagnostic_fees_month' => $diagnosticFeesThisMonth,
            'diagnostic_fees' => $totalDiagnosticFees,
            
            // Expected future revenue
            'expected_downpayments' => $expectedDownpayments,
            
            // Overall metrics
            'total_revenue' => $totalRevenue,
            'approval_rate' => $approvalRate,
        ],
        'counts' => [
            'total_quotations' => $totalQuotations,
            'approved' => $approvedCount,
            'pending' => $pendingCount,
            'rejected' => $rejectedCount,
            'total_jobs' => JobOrder::count(),
            'completed_jobs' => JobOrder::where('status', 'completed')->count(),
            'active_jobs' => JobOrder::whereIn('status', ['scheduled', 'in_progress'])->count(),
        ],
    ];
    
    // Get job orders with pagination for the main table
    $recentJobOrders = JobOrder::with(['quotation.customer'])
        ->orderByDesc('created_at')
        ->paginate(12);
    
    // Optional: Keep quotations table if you want both
    $reportRows = Quotation::with(['customer', 'inquiry'])
        ->orderByDesc('date_issued')
        ->paginate(12);
    
    return view('manager.reports', compact('stats', 'recentJobOrders', 'reportRows'));
}

public function sales()
{
    $now = Carbon::now();
    
    // Monthly revenue from completed jobs
    $monthlyRevenue = JobOrder::where('status', 'completed')
        ->whereMonth('completed_at', $now->month)
        ->whereYear('completed_at', $now->year)
        ->sum('subtotal');
    
    // Average job ticket (from completed jobs)
    $avgTicket = JobOrder::where('status', 'completed')
        ->avg('subtotal') ?? 0;
    
    // Conversion rate: approved quotations → completed jobs
    $approvedQuotations = Quotation::where('status', 'approved')->count();
    $completedJobs = JobOrder::where('status', 'completed')->count();
    $conversionRate = $approvedQuotations > 0
        ? round(($completedJobs / $approvedQuotations) * 100, 1)
        : 0;
    
    $stats = [
        'monthly' => [
            'total_revenue' => '₱ ' . number_format($monthlyRevenue, 2),
            'avg_ticket' => '₱ ' . number_format($avgTicket, 2),
            'conversion_rate' => $conversionRate . '%',
        ],
        'pipeline' => [
            'open_quotes' => Quotation::where('status', 'pending')->count(),
            'won_quotes' => Quotation::where('status', 'approved')->count(),
            'active_jobs' => JobOrder::whereIn('status', ['scheduled', 'in_progress'])->count(),
            'completed_jobs' => $completedJobs,
        ],
    ];
    
    // Recent transactions (completed job orders)
    $recentTransactions = JobOrder::where('status', 'completed')
        ->with(['quotation.customer'])
        ->orderByDesc('completed_at')
        ->limit(10)
        ->get();
    
    return view('manager.sales', compact('stats', 'recentTransactions'));
}
}
