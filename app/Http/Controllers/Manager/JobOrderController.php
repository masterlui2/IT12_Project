<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;

class JobOrderController extends Controller
{
    public function index(Request $request)
    {  // optional filters from search & status
        $query = JobOrder::query();

       $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
        ];

        if ($filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
              $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('quotation', function ($sub) use ($search) {
                        $sub->where('project_title', 'like', "%{$search}%")
                            ->orWhere('client_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        $jobOrders = $query->with('quotation')->latest()->paginate(10);

        $stats = [
            'total'    => JobOrder::count(),
            'active'   => JobOrder::whereIn('status', ['scheduled', 'in_progress'])->count(),
        ];

        return view('manager.job.index', compact('jobOrders', 'stats', 'filters'));
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
    public function update(Request $request, $id)
{
    $job = \App\Models\JobOrder::findOrFail($id);

    $validated = $request->validate([
        'technician_notes' => 'nullable|string',
        'status' => 'required|string|in:scheduled,in_progress,review,completed,cancelled',
    ]);

    $job->update([
        'technician_notes' => $validated['technician_notes'] ?? $job->technician_notes,
        'status' => $validated['status'],
        'completed_at' => $validated['status'] === 'completed' ? now() : null,
    ]);

    return back()->with('status', 'Job updated successfully.');
}

}
