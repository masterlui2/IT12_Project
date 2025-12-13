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

        return view('manager.job.index', compact('jobOrders'));
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
}
