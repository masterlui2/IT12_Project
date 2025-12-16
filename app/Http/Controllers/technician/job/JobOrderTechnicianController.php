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

        if (!$technician) {
            return redirect()->route('technician.dashboard')
                ->with('error', 'No technician profile found for this account.');
        }

        // Base query: ONLY this technician's jobs
        $query = JobOrder::query()
            ->where('technician_id', $technician->id)
            ->with([
                'quotation.customer',
                'quotation.inquiry',
            ]);

        // Search: JO id or customer name (via quotation/customer), or inquiry issue/device
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            // If user types "JO-00001" or "00001"
            $numericId = (int) preg_replace('/\D+/', '', $search);

            $query->where(function ($q) use ($search, $numericId) {
                if ($numericId > 0) {
                    $q->orWhere('id', $numericId);
                }

                // If you still have a job_orders.customer_name column, this will work too:
                $q->orWhere('customer_name', 'like', "%{$search}%");

                // Search from quotation
                $q->orWhereHas('quotation', function ($qq) use ($search) {
                    $qq->where('client_name', 'like', "%{$search}%")
                       ->orWhere('project_title', 'like', "%{$search}%");
                });

                // Search from customer relation (if exists)
                $q->orWhereHas('quotation.customer', function ($qc) use ($search) {
                    $qc->where('firstname', 'like', "%{$search}%")
                       ->orWhere('lastname', 'like', "%{$search}%")
                       ->orWhereRaw("CONCAT(firstname,' ',lastname) LIKE ?", ["%{$search}%"]);
                });

                // Search from inquiry relation (if exists)
                $q->orWhereHas('quotation.inquiry', function ($qi) use ($search) {
                    $qi->where('device_type', 'like', "%{$search}%")
                       ->orWhere('issue_description', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobOrders = (clone $query)->latest()->paginate(10);

        $stats = [
            'total'  => (clone $query)->count(),
            'active' => (clone $query)->whereIn('status', ['scheduled', 'in_progress'])->count(),
        ];

        return view('technician.contents.job.index', compact('jobOrders', 'stats'));
    }

    public function show($id)
    {
        $technician = Auth::user()->technician;

        $job = JobOrder::with(['quotation.customer', 'quotation.inquiry', 'items'])
            ->where('technician_id', $technician?->id)
            ->findOrFail($id);

        return view('technician.contents.job.show', compact('job'));
    }

    public function edit($id)
    {
        $technician = Auth::user()->technician;

        $job = JobOrder::with(['quotation.customer', 'quotation.inquiry', 'items'])
            ->where('technician_id', $technician?->id)
            ->findOrFail($id);

        return view('technician.contents.job.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $technician = Auth::user()->technician;

        $job = JobOrder::where('technician_id', $technician?->id)->findOrFail($id);

        $validated = $request->validate([
            'start_date'            => 'required|date',
            'expected_finish_date'  => 'nullable|date',
            'timeline_min_days'     => 'nullable|integer|min:1',
            'timeline_max_days'     => 'nullable|integer|min:1',
            'technician_notes'      => 'nullable|string',

            'items'                 => 'required|array|min:1',
            'items.*.name'          => 'required|string|max:255',
            'items.*.description'   => 'nullable|string',
            'items.*.quantity'      => 'required|numeric|min:0',
            'items.*.unit_price'    => 'required|numeric|min:0',

            // optional status updates from technician side
            'status' => 'nullable|string|in:scheduled,in_progress,review,completed,cancelled',
        ]);

        // Compute expected_finish_date from start_date + timeline_max_days if provided
        $expectedFinishDate = $validated['expected_finish_date'] ?? null;

        if (!empty($validated['start_date']) && !empty($validated['timeline_max_days'])) {
            $expectedFinishDate = Carbon::parse($validated['start_date'])
                ->addDays((int) $validated['timeline_max_days'])
                ->toDateString();
        }

        // Prepare update payload
        $updateData = [
            'start_date'           => $validated['start_date'],
            'expected_finish_date' => $expectedFinishDate,
            'timeline_min_days'    => $validated['timeline_min_days'] ?? null,
            'timeline_max_days'    => $validated['timeline_max_days'] ?? null,
            'technician_notes'     => $validated['technician_notes'] ?? null,
        ];

        // Optional status change
        if (!empty($validated['status'])) {
            $updateData['status'] = $validated['status'];

            // Only set completed_at when truly completed
            if ($validated['status'] === 'completed' && $job->status !== 'completed') {
                $updateData['completed_at'] = now();
            }

            // If moving away from completed, you may want to clear completed_at (optional)
            if ($validated['status'] !== 'completed') {
                $updateData['completed_at'] = null;
            }
        }

        // Update job
        $job->update($updateData);

        // Replace items (simple approach)
        $job->items()->delete();

        foreach ($validated['items'] as $itemData) {
            $quantity = (float) ($itemData['quantity'] ?? 0);
            $unitPrice = (float) ($itemData['unit_price'] ?? 0);

            $job->items()->create([
                'name'        => $itemData['name'],
                'description' => $itemData['description'] ?? '',
                'quantity'    => $quantity,
                'unit_price'  => $unitPrice,
                'total'       => $quantity * $unitPrice,
            ]);
        }

        return redirect()->route('technician.job.index')
            ->with('success', 'Job order updated successfully!');
    }

    public function in_progress($id)
    {
        $technician = Auth::user()->technician;

        $job = JobOrder::where('technician_id', $technician?->id)->findOrFail($id);

        // Only allow if not completed/cancelled (optional guard)
        if (in_array($job->status, ['completed', 'cancelled'], true)) {
            return redirect()->route('technician.job.index')
                ->with('error', 'You cannot start a job that is already completed or cancelled.');
        }

        $job->update(['status' => 'in_progress']);

        return redirect()->route('technician.job.index')
            ->with('success', 'Job moved to In Progress.');
    }
}
