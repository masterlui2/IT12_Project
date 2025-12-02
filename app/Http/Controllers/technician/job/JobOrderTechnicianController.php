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
            $query->where('technician_id', $technician->user_id);
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

    public function show(){
        return view('technician.contents.job.index');
    }
    public function edit(){
        return view('technician.contents.job.index');
    }
    public function markComplete(){
        return view('technician.contents.job.index');
    }
}
