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
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $expectedFinishDate = null;
        if ($request->start_date && $request->timeline_max_days) {
            $expectedFinishDate = Carbon::parse($request->start_date)
                ->addDays((int)$request->timeline_max_days)
                ->format('Y-m-d'); // store as normal date
        }

        // Update job order main fields
        $job->update([
            'start_date' => $request->start_date,
            'expected_finish_date' => $expectedFinishDate,
            'timeline_min_days' => $request->timeline_min_days,
            'timeline_max_days' => $request->timeline_max_days,
            'technician_notes' => $request->technician_notes,
        ]);

        // Handle items: Delete all and recreate (simpler approach)
        $job->items()->delete();

        foreach ($request->items as $itemData) {
            if (!empty($itemData['name'])) {
                $quantity = (float) ($itemData['quantity'] ?? 0);
                $unitPrice = (float) ($itemData['unit_price'] ?? 0);
                
                $job->items()->create([
                    'name' => $itemData['name'],
                    'description' => $itemData['description'] ?? '',
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $quantity * $unitPrice,
                ]);
            }
        }

        // Handle action buttons
        if ($request->action === 'complete') {
            $job->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
            return redirect()->route('technician.job.index')
                ->with('success', 'Job order marked as completed!');
        }

        // Default save action
        return redirect()->route('technician.job.index')
            ->with('success', 'Job order updated successfully!');
    }


    public function markComplete($id)
    {
        $job = JobOrder::findOrFail($id);
        $job->markAsCompleted();

        return redirect()->route('technician.job.index')
            ->with('success', 'Job marked as completed!');
    }
}
