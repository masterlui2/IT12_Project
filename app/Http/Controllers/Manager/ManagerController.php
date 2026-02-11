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
                                   $query->latest()->take(1); // ✅ only latest job per technician

                }, 'jobOrders.quotation'])
                ->withCount('jobOrders')
                ->get();

        $approvedQuotations = Quotation::where('status', 'approved')
            ->orderByDesc('date_issued')
            ->get();

         $jobOrderHistory = JobOrder::with(['technician.user', 'quotation.customer'])
            ->latest()
            ->take(10)
            ->get();

        return view('manager.technicians', compact('technicians', 'approvedQuotations', 'jobOrderHistory'));
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
    abort_unless(Auth::check(), 403, 'Not authenticated.');

    $validated = $request->validate([
        'technician_id'         => 'required|exists:technicians,id',
        'quotation_id'          => 'required|exists:quotations,id',
        'start_date'            => 'nullable|date',
        'expected_finish_date'  => 'nullable|date|after_or_equal:start_date',
        'timeline_min_days'     => 'nullable|integer|min:1',
        'timeline_max_days'     => 'nullable|integer|min:1',
        'technician_notes'      => 'nullable|string',
        'status'                => 'nullable|string|in:scheduled,in_progress,review,completed,cancelled',
    ]);

    JobOrder::create([
        ...$validated,
        'user_id' => (int) Auth::id(),
        'status'  => $validated['status'] ?? 'scheduled',
    ]);

    return redirect()->route('technicians')
        ->with('status', 'Job order assigned to technician successfully.');
}

    

    public function customers()
    {
        return view('manager.customers');
    }
    public function reports(Request $request)
{
    $now = Carbon::now();
    
    // ===== DATE FILTERING =====
    $period = $request->get('period', 'all_time');
    $dateFrom = $request->get('date_from');
    $dateTo = $request->get('date_to');
    
    // Calculate date range based on period
    switch ($period) {
        case 'this_week':
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
            break;
        case 'this_month':
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            break;
        case 'last_month':
            $startDate = $now->copy()->subMonth()->startOfMonth();
            $endDate = $now->copy()->subMonth()->endOfMonth();
            break;
        case 'this_year':
            $startDate = $now->copy()->startOfYear();
            $endDate = $now->copy()->endOfYear();
            break;
        case 'custom':
            $startDate = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : null;
            $endDate = $dateTo ? Carbon::parse($dateTo)->endOfDay() : null;
            break;
        case 'all_time':
        default:
            $startDate = null;
            $endDate = null;
    }
    
    // ===== JOB ORDER REVENUE (With Date Filter) =====
    $completedJobsQuery = JobOrder::with('quotation.details')
        ->where('status', 'completed');
    
    // Apply date filter only if date range is set
    if ($startDate && $endDate) {
        $completedJobsQuery->whereBetween('completed_at', [$startDate, $endDate]);
    }
    
    $completedJobs = $completedJobsQuery->get();
    
    // Calculate revenue from quotation details
    $completedJobsRevenue = $completedJobs->sum(function($job) {
        return $job->subtotal ?? $job->quotation?->subtotal ?? 0;
    });
    
    // Downpayment is 50% of subtotal
    $downpaymentsReceived = $completedJobsRevenue * 0.50;
    
    // Remaining balance is the other 50%
    $remainingBalance = $completedJobsRevenue * 0.50;
    
    // ===== DIAGNOSTIC FEES (With Date Filter) =====
    $diagnosticFeesQuery = Quotation::query();
    
    if ($startDate && $endDate) {
        $diagnosticFeesQuery->whereBetween('date_issued', [$startDate, $endDate]);
    }
    
    $totalDiagnosticFees = $diagnosticFeesQuery->sum('diagnostic_fee');
    
    // ===== TOTAL REVENUE CALCULATION =====
    $totalRevenue = $completedJobsRevenue + $totalDiagnosticFees;
    
    // ===== JOB COUNTS (With Date Filter) =====
    $totalJobsQuery = JobOrder::query();
    $activeJobsQuery = JobOrder::whereIn('status', ['scheduled', 'in_progress']);
    
    if ($startDate && $endDate) {
        $totalJobsQuery->whereBetween('created_at', [$startDate, $endDate]);
        $activeJobsQuery->whereBetween('created_at', [$startDate, $endDate]);
    }
    
    $totalJobs = $totalJobsQuery->count();
    $completedJobsCount = $completedJobs->count();
    $activeJobs = $activeJobsQuery->count();
    
    // ===== APPROVAL METRICS (With Date Filter) =====
    $quotationsQuery = Quotation::query();
    $approvedQuery = Quotation::where('status', 'approved');
    
    if ($startDate && $endDate) {
        $quotationsQuery->whereBetween('date_issued', [$startDate, $endDate]);
        $approvedQuery->whereBetween('date_issued', [$startDate, $endDate]);
    }
    
    $totalQuotations = $quotationsQuery->count();
    $approvedCount = $approvedQuery->count();
    
    $approvalRate = $totalQuotations > 0
        ? round(($approvedCount / $totalQuotations) * 100, 1)
        : 0;
    
    // ===== AVERAGE JOB VALUE =====
    $avgJobValue = $completedJobsCount > 0 ? ($completedJobsRevenue / $completedJobsCount) : 0;
    
    // ===== CHART DATA =====
    $chartData = $this->generateChartData($startDate, $endDate);
    
    $stats = [
        'reports' => [
            'completed_jobs_revenue' => $completedJobsRevenue,
            'downpayments_received' => $downpaymentsReceived,
            'remaining_balance' => $remainingBalance,
            'diagnostic_fees' => $totalDiagnosticFees,
            'total_revenue' => $totalRevenue,
            'approval_rate' => $approvalRate,
            'avg_job_value' => $avgJobValue,
        ],
        'counts' => [
            'total_jobs' => $totalJobs,
            'completed_jobs' => $completedJobsCount,
            'active_jobs' => $activeJobs,
        ],
    ];
    
    // ===== RECENT JOB ORDERS (With Date Filter) =====
    $recentJobsQuery = JobOrder::with(['quotation.customer', 'technician.user']);
    
    if ($startDate && $endDate) {
        $recentJobsQuery->whereBetween('created_at', [$startDate, $endDate]);
    }
    
    $recentJobs = $recentJobsQuery
        ->orderByDesc('created_at')
        ->limit(10)
        ->get()
        ->map(function($job) {
            // Add computed subtotal if not in database
            if (!$job->subtotal && $job->quotation) {
                $job->subtotal = $job->quotation->subtotal;
            }
            return $job;
        });
    
    // ===== TOP REVENUE JOBS (With Date Filter) =====
    $topRevenueQuery = JobOrder::with(['quotation.customer', 'quotation.details'])
        ->where('status', 'completed');
    
    if ($startDate && $endDate) {
        $topRevenueQuery->whereBetween('completed_at', [$startDate, $endDate]);
    }
    
    $topRevenueJobs = $topRevenueQuery
        ->get()
        ->map(function($job) {
            // Calculate subtotal from quotation if not in job order
            $job->calculated_subtotal = $job->subtotal ?? $job->quotation?->subtotal ?? 0;
            return $job;
        })
        ->sortByDesc('calculated_subtotal')
        ->take(5);
    
    // ===== TECHNICIAN PERFORMANCE (With Date Filter) =====
    $technicianPerformance = Technician::with('user')
        ->get()
        ->map(function ($technician) use ($startDate, $endDate) {
            $totalJobsQuery = JobOrder::where('technician_id', $technician->id);
            $completedJobsQuery = JobOrder::with('quotation.details')
                ->where('technician_id', $technician->id)
                ->where('status', 'completed');
            $activeJobsQuery = JobOrder::where('technician_id', $technician->id)
                ->whereIn('status', ['scheduled', 'in_progress']);
            
            if ($startDate && $endDate) {
                $totalJobsQuery->whereBetween('created_at', [$startDate, $endDate]);
                $completedJobsQuery->whereBetween('completed_at', [$startDate, $endDate]);
                $activeJobsQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            $totalJobs = $totalJobsQuery->count();
            $completedJobsList = $completedJobsQuery->get();
            $completedJobs = $completedJobsList->count();
            $activeJobs = $activeJobsQuery->count();
            
            // Calculate revenue from quotation subtotals
            $totalRevenue = $completedJobsList->sum(function($job) {
                return $job->subtotal ?? $job->quotation?->subtotal ?? 0;
            });
            
            $avgJobValue = $completedJobs > 0 ? ($totalRevenue / $completedJobs) : 0;
            
            return (object) [
                'id' => $technician->id,
                'name' => $technician->name,
                'total_jobs' => $totalJobs,
                'completed_jobs' => $completedJobs,
                'active_jobs' => $activeJobs,
                'total_revenue' => $totalRevenue,
                'avg_job_value' => $avgJobValue,
            ];
        })
        ->filter(function($tech) {
            // Only show technicians with at least one job in the period
            return $tech->total_jobs > 0;
        })
        ->sortByDesc('total_revenue');
    
    return view('manager.reports', compact(
        'stats', 
        'recentJobs', 
        'topRevenueJobs', 
        'technicianPerformance',
        'chartData'
    ));
}

/**
 * Generate chart data for revenue visualization
 */
private function generateChartData($startDate, $endDate)
{
    // If no date range, use last 30 days
    if (!$startDate || !$endDate) {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(30);
    }
    
    $labels = [];
    $revenueData = [];
    $completedRevenueData = [];
    $diagnosticFeesData = [];
    
    // Determine interval based on date range
    $daysDiff = $startDate->diffInDays($endDate);
    
    if ($daysDiff <= 7) {
        // Daily breakdown for week or less
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $labels[] = $current->format('D');
            
            $dayStart = $current->copy()->startOfDay();
            $dayEnd = $current->copy()->endOfDay();
            
            $completedRevenue = JobOrder::with('quotation.details')
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$dayStart, $dayEnd])
                ->get()
                ->sum(function($job) {
                    return $job->subtotal ?? $job->quotation?->subtotal ?? 0;
                });
            
            $diagnosticFees = Quotation::whereBetween('date_issued', [$dayStart, $dayEnd])
                ->sum('diagnostic_fee');
            
            $completedRevenueData[] = $completedRevenue;
            $diagnosticFeesData[] = $diagnosticFees;
            $revenueData[] = $completedRevenue + $diagnosticFees;
            
            $current->addDay();
        }
    } elseif ($daysDiff <= 31) {
        // Daily breakdown for month
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $labels[] = $current->format('M j');
            
            $dayStart = $current->copy()->startOfDay();
            $dayEnd = $current->copy()->endOfDay();
            
            $completedRevenue = JobOrder::with('quotation.details')
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$dayStart, $dayEnd])
                ->get()
                ->sum(function($job) {
                    return $job->subtotal ?? $job->quotation?->subtotal ?? 0;
                });
            
            $diagnosticFees = Quotation::whereBetween('date_issued', [$dayStart, $dayEnd])
                ->sum('diagnostic_fee');
            
            $completedRevenueData[] = $completedRevenue;
            $diagnosticFeesData[] = $diagnosticFees;
            $revenueData[] = $completedRevenue + $diagnosticFees;
            
            $current->addDay();
        }
    } else {
        // Weekly breakdown for longer periods
        $current = $startDate->copy()->startOfWeek();
        $end = $endDate->copy()->endOfWeek();
        
        while ($current <= $end) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek();
            
            if ($weekEnd > $endDate) {
                $weekEnd = $endDate->copy();
            }
            
            $labels[] = $weekStart->format('M j');
            
            $completedRevenue = JobOrder::with('quotation.details')
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$weekStart, $weekEnd])
                ->get()
                ->sum(function($job) {
                    return $job->subtotal ?? $job->quotation?->subtotal ?? 0;
                });
            
            $diagnosticFees = Quotation::whereBetween('date_issued', [$weekStart, $weekEnd])
                ->sum('diagnostic_fee');
            
            $completedRevenueData[] = $completedRevenue;
            $diagnosticFeesData[] = $diagnosticFees;
            $revenueData[] = $completedRevenue + $diagnosticFees;
            
            $current->addWeek();
        }
    }
    
    return [
        'labels' => $labels,
        'revenue' => $revenueData,
        'completed_revenue' => $completedRevenueData,
        'diagnostic_fees' => $diagnosticFeesData,
    ];
}

/**
 * Export reports to CSV
 */
public function exportReports(Request $request)
    {
        // Fix 1: Default to 'all_time' for consistency with reports() method
        $period = $request->get('period', 'all_time');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $now = Carbon::now();

        // Calculate date range (same logic as reports method)
        switch ($period) {
            case 'this_week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'this_month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $now->copy()->subMonth()->startOfMonth();
                $endDate = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            case 'custom':
                // Fix 2: Align 'custom' date handling with reports() method
                $startDate = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : null;
                $endDate = $dateTo ? Carbon::parse($dateTo)->endOfDay() : null;
                break;
            case 'all_time': // Explicitly handle 'all_time'
            default: // Default case should also result in all time if not specified
                $startDate = null;
                $endDate = null;
                break;
        }

        // Get job orders for export
        $jobsQuery = JobOrder::with(['quotation.customer', 'technician']);

        // Fix 3: Only apply whereBetween if startDate and endDate are not null
        if ($startDate && $endDate) {
            $jobsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $jobs = $jobsQuery->orderByDesc('created_at')->get();

        // Generate CSV
        $filename = 'reports_' .
                    ($startDate ? $startDate->format('Y-m-d') : 'all_time_from') .
                    '_to_' .
                    ($endDate ? $endDate->format('Y-m-d') : 'all_time_to') .
                    '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($jobs) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Job Order ID',
                'Customer Name',
                'Project Title',
                'Technician',
                'Status',
                'Created Date',
                'Completed Date',
                'Subtotal',
                'Downpayment',
                'Total Amount',
                'Diagnostic Fee'
            ]);

            // CSV Rows
            foreach ($jobs as $job) {
                fputcsv($file, [
                    'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT),
                    $job->quotation?->client_name ?? $job->customer_name ?? '—',
                    $job->quotation?->project_title ?? '—',
                    $job->technician?->name ?? '—',
                    ucfirst(str_replace('_', ' ', $job->status ?? 'pending')),
                    $job->created_at?->format('Y-m-d H:i:s') ?? '—',
                    $job->completed_at?->format('Y-m-d H:i:s') ?? '—',
                    number_format($job->subtotal ?? 0, 2),
                    number_format($job->downpayment ?? 0, 2),
                    number_format($job->total_amount ?? 0, 2),
                    number_format($job->quotation?->diagnostic_fee ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
