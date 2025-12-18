<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;

class JobOrderController extends Controller
{
    public function index(Request $request)
{  
    // Optional filters from search & status
    $query = JobOrder::query();

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

    // ✅ Eager load quotation and technician relationships
    $jobOrders = $query->with(['quotation', 'technician.user'])->latest()->paginate(10);

    // ✅ Get all technicians for the dropdown
    $technicians = \App\Models\Technician::with('user')->get();

    return view('manager.job.index', compact('jobOrders', 'technicians'));
}

    public function markComplete($id)
    {
        $job = JobOrder::findOrFail($id);
        $job->markAsCompleted();

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

        $jobOrder = JobOrder::findOrFail($id);
        
        $jobOrder->update([
            'technician_id' => $request->technician_id,
        ]);

        return redirect()->back()->with('success', 'Technician assigned successfully.');
    }
}
