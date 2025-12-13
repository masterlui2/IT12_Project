<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\JobOrder;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TechnicianController extends Controller
{
    public function dashboard(){
 $technicianId = optional(Auth::user()->technician)->id;

        $jobOrdersQuery = JobOrder::query()
            ->where('technician_id', $technicianId ?? 0);

        $metrics = [
            'active_jobs' => (clone $jobOrdersQuery)->whereIn('status', ['scheduled', 'in_progress'])->count(),
            'completed_jobs' => (clone $jobOrdersQuery)->where('status', 'completed')->count(),
            'open_inquiries' => Inquiry::query()
                ->where('assigned_technician_id', $technicianId ?? 0)
                ->where(function ($query) {
                    $query->whereNull('status')->orWhere('status', '!=', 'closed');
                })
                ->count(),
            'quotations' => Quotation::query()
                ->where('technician_id', $technicianId ?? 0)
                ->count(),
        ];

        $recentJobOrders = $jobOrdersQuery
            ->with('quotation')
            ->latest()
            ->take(5)
            ->get();

        $recentInquiries = Inquiry::query()
            ->where('assigned_technician_id', $technicianId ?? 0)
            ->latest()
            ->take(4)
            ->get();

        $recentQuotations = Quotation::query()
            ->where('technician_id', $technicianId ?? 0)
            ->latest()
            ->take(3)
            ->get();

        return view('technician.contents.dashboard', [
            'metrics' => $metrics,
            'recentJobOrders' => $recentJobOrders,
            'recentInquiries' => $recentInquiries,
            'recentQuotations' => $recentQuotations,
        ]);
        }

   public function messages(Request $request)
    {
        $customerThreads = Message::with('user')
            ->whereHas('user', fn ($query) => $query->where('role', 'customer'))
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(function ($messages) {
                $latest = $messages->first();

                return (object) [
                    'user' => $latest?->user,
                    'latest_message' => $latest,
                    'count' => $messages->count(),
                ];
            })
            ->sortByDesc(fn ($thread) => optional($thread->latest_message)->created_at);

        $activeCustomerId = $request->integer('customer_id') ?: $customerThreads->keys()->first();
        $activeCustomer = $activeCustomerId ? optional($customerThreads->get($activeCustomerId))->user : null;
        $activeInquiry = null;

        $messages = collect();

        if ($activeCustomerId) {
            $activeInquiry = Inquiry::where('customer_id', $activeCustomerId)
                ->latest()
                ->first();

            $messages = Message::with('user')
                ->whereIn('user_id', [$activeCustomerId, Auth::id()])
                ->orderBy('created_at')
                ->get();
        }

        return view('technician.contents.messages', [
            'messages' => $messages,
            'customerThreads' => $customerThreads,
            'activeCustomer' => $activeCustomer,
            'activeCustomerId' => $activeCustomerId,
            'activeInquiry' => $activeInquiry,
        ]);
        }

    public function reporting(){
 $technician = Auth::user()->technician;

        if (!$technician) {
            return redirect()->route('technician.dashboard')
                ->with('error', 'No technician profile found for this account.');
        }

        $quotationQuery = Quotation::where('technician_id', $technician->id);
        $jobOrderQuery = JobOrder::where('technician_id', $technician->id);
        $inquiryQuery = Inquiry::where('assigned_technician_id', $technician->id);

        $stats = [
            'totals' => [
                'quotations' => $quotationQuery->count(),
                'inquiries' => $inquiryQuery->count(),
                'approved_quotes' => (clone $quotationQuery)->where('status', 'approved')->count(),
            ],
            'jobs' => [
                'active' => (clone $jobOrderQuery)->whereIn('status', ['scheduled', 'in_progress'])->count(),
                'completed' => (clone $jobOrderQuery)->where('status', 'completed')->count(),
                'cancelled' => (clone $jobOrderQuery)->where('status', 'cancelled')->count(),
            ],
            'revenue' => [
                'quotations' => (clone $quotationQuery)->where('status', 'approved')->sum('grand_total'),
                'jobs' => (clone $jobOrderQuery)->sum(DB::raw('COALESCE(diagnostic_fee,0)+COALESCE(materials_cost,0)+COALESCE(professional_fee,0)')),
            ],
        ];

        $stats['revenue']['overall'] = $stats['revenue']['quotations'] + $stats['revenue']['jobs'];

        $recentJobs = (clone $jobOrderQuery)
            ->with('quotation')
            ->latest()
            ->take(5)
            ->get();

        $recentQuotations = (clone $quotationQuery)
            ->with('inquiry')
            ->latest()
            ->take(5)
            ->get();

        return view('technician.contents.reporting', compact(
            'stats',
            'recentJobs',
            'recentQuotations',
        ));    }

    public function inquire()
    {
        // Get the current technician record linked to the user
        $technician = Auth::user()->technician;

        // Build query: show unclaimed or assigned to this technician only
        $inquiries = Inquiry::where(function ($q) use ($technician) {
                $q->whereNull('assigned_technician_id')
                ->orWhere('assigned_technician_id', $technician->id);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('technician.contents.inquiries.index', compact('inquiries'));
    }

    public function claim($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Prevent re-claiming if already assigned
        if ($inquiry->assigned_technician_id) {
            return redirect()->back()->with('error', 'This inquiry is already claimed.');
        }

        // Authenticated user hasOne Technician
        $technician = Auth::user()->technician;

        if (! $technician) {
            return redirect()->back()->with('error', 'You are not registered as a technician.');
        }

        $inquiry->assigned_technician_id = $technician->id; // ✅ use technician ID
        $inquiry->status = 'Acknowledged';
        $inquiry->save();

        return redirect()->route('technician.inquire.index')
            ->with('success', 'Inquiry INQ-' . str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) . ' claimed successfully.');
    }

    public function inquireShow(int $id)
    {
        // Fetch inquiry with necessary relationships
        $inquiry = Inquiry::with('technician', 'customer')->findOrFail($id);

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
