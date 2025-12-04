<?php

namespace App\Http\Controllers\Technician\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobOrder;

class JobOrderTechnicianController extends Controller
{
    public function index(Request $request)
    {
        $technician = Auth::user()->technician;

        // optional filters from search & status
        $query = JobOrder::query();

        if ($technician) {
            $query->where('technician_id', $technician->id);
        }

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

        $jobOrders = $query->with('quotation')->latest()->paginate(10);

        return view('technician.contents.job.index', compact('jobOrders'));
    }

    public function show($id)
    {
        $job = JobOrder::with('quotation')->findOrFail($id);
        return view('technician.contents.job.show', compact('job'));
    }

    public function edit($id)
    {
        $job = JobOrder::with('quotation')->findOrFail($id);
        return view('technician.contents.job.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = JobOrder::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'device_type' => 'nullable|string|max:100',
            'issue_description' => 'nullable|string',
            'diagnostic_fee' => 'nullable|numeric|min:0',
            'materials_cost' => 'nullable|numeric|min:0',
            'professional_fee' => 'nullable|numeric|min:0',
            'expected_finish_date' => 'nullable|date',
            'status' => 'required|string|in:scheduled,in_progress,completed,cancelled',
            'technician_notes' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $job->update($request->only([
            'customer_name',
            'contact_number',
            'device_type',
            'issue_description',
            'diagnostic_fee',
            'materials_cost',
            'professional_fee',
            'expected_finish_date',
            'status',
            'technician_notes',
            'remarks',
        ]));

        return redirect()->route('technician.job.index')->with('success', 'Job order updated successfully!');
    }


    public function markComplete($id)
    {
        $job = JobOrder::findOrFail($id);
        $job->status = 'completed';
        $job->completed_at = now();
        $job->save();

        return redirect()->route('technician.job.index')->with('success', 'Job marked as completed!');
    }
}
