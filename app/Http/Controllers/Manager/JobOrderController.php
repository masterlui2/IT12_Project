<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOrderController extends Controller
{
    public function index(Request $request)
    {
        // Optional filters from search & status

        // Optional filters from search & status
        $query = JobOrder::query();
        $filters = $request->only(['search', 'status']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Eager load quotation and technician relationships
        $jobOrders = $query->with(['quotation', 'technician.user'])->latest()->paginate(10);

        // Get all technicians for the dropdown
        $technicians = \App\Models\Technician::with('user')->get();

        // Summary counts used by the index view
        $stats = [
            'total' => JobOrder::count(),
            'active' => JobOrder::where('status', 'in_progress')->count(),
        ];

        return view('manager.job.index', [
            'jobOrders' => $jobOrders,
            'technicians' => $technicians,
            'stats' => $stats,
            'filters' => $filters,
        ]);

    }

    public function markComplete($id)
    {
        $job = JobOrder::with('quotation')->findOrFail($id);
        $job->markAsCompleted();

        $quotation = $job->quotation;

        AuditLogger::log('manager.job_order.completed', [
            'manager_user_id' => Auth::id(),
            'technician_id' => $job->technician_id,
            'job_order_id' => $job->id,
            'quotation_id' => $job->quotation_id,
            'inquiry_id' => $quotation?->inquiry_id,
        ], Auth::id());

        return redirect()->route('manager.job.index')
            ->with('success', 'Job marked as completed!');
    }

    public function show($id)
    {
        $job = JobOrder::with('quotation')->findOrFail($id);

        return view('manager.job.show', compact('job'));
    }

    public function assignTechnician(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $jobOrder = JobOrder::with('quotation')->findOrFail($id);

        $jobOrder->update([
            'technician_id' => $request->technician_id,
        ]);

        $quotation = $jobOrder->quotation;

        AuditLogger::log('manager.job_order.technician_assigned', [
            'manager_user_id' => Auth::id(),
            'technician_id' => (int) $request->technician_id,
            'job_order_id' => $jobOrder->id,
            'quotation_id' => $jobOrder->quotation_id,
            'inquiry_id' => $quotation?->inquiry_id,
        ], Auth::id());

        return redirect()->back()->with('success', 'Technician assigned successfully.');
    }
}
