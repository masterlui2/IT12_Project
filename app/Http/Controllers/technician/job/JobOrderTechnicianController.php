<?php

namespace App\Http\Controllers\Technician\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobOrder;
use Carbon\Carbon;
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
        'start_date' => 'required|date',
        'expected_finish_date' => 'nullable|date',
        'timeline_min_days' => 'nullable|integer|min:1',
        'timeline_max_days' => 'nullable|integer|min:1',
        'technician_notes' => 'nullable|string',
        'items' => 'array|min:1',
        'items.*.name' => 'string|max:255',
        'items.*.description' => 'nullable|string',
        'items.*.quantity' => 'numeric|min:0',
        'items.*.unit_price' => 'numeric|min:0',
    ]);

    $expectedFinishDate = null;
    if ($request->start_date && $request->timeline_max_days) {
        $expectedFinishDate = Carbon::parse($request->start_date)
            ->addDays((int)$request->timeline_max_days)
            ->format('Y-m-d');
    }

    // Calculate totals from items
    $subtotal = 0;
    $itemsData = [];
    
    foreach ($request->items as $itemData) {
        if (!empty($itemData['name'])) {
            $quantity = (float) ($itemData['quantity'] ?? 0);
            $unitPrice = (float) ($itemData['unit_price'] ?? 0);
            $total = $quantity * $unitPrice;
            
            $subtotal += $total;
            
            $itemsData[] = [
                'name' => $itemData['name'],
                'description' => $itemData['description'] ?? '',
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total' => $total,
            ];
        }
    }
    
    // Calculate downpayment (50%) and total amount (remaining balance)
    $downpayment = $subtotal * 0.50;
    $totalAmount = $subtotal - $downpayment; // Remaining balance after downpayment

    // Update job order with calculated values
    $job->update([
        'start_date' => $request->start_date,
        'expected_finish_date' => $expectedFinishDate,
        'timeline_min_days' => $request->timeline_min_days,
        'timeline_max_days' => $request->timeline_max_days,
        'technician_notes' => $request->technician_notes,
        'subtotal' => $subtotal,
        'downpayment' => $downpayment,
        'total_amount' => $totalAmount,
    ]);

    // Handle items: Delete all and recreate
    $job->items()->delete();
    
    foreach ($itemsData as $item) {
        $job->items()->create($item);
    }

    // Handle action buttons
    if ($request->action === 'completed') {
        $job->markAsCompleted();
        return redirect()->route('technician.job.index')
            ->with('success', 'Job order marked as completed!');
    }

    // Default save action
    return redirect()->route('technician.job.index')
        ->with('success', 'Job order updated successfully!');
}

    public function in_progress($id){
       $job = JobOrder::findOrFail($id);
       $job->update([
        'status' => 'in_progress',
        'start_date' => now()->format('Y-m-d')  // or now()->toDateString()
        ]);
       return redirect()->route('technician.job.index');
    }
}