<?php

namespace App\Observers;

use App\Models\Quotation;
use App\Models\JobOrder;

class QuotationObserver
{
    public function updated(Quotation $quotation): void
    {
        if ($quotation->isDirty('status') && $quotation->status === 'approved') {
            // Create job order
            $jobOrder = JobOrder::create([
                'quotation_id' => $quotation->id,
                'technician_id' => $quotation->technician_id,
                'expected_finish_date' => now()->addDays($quotation->timeline_max_days ?? 5),
                'status' => 'scheduled',
            ]);

            // Optionally copy quotation items as initial job order items
            // (Technician can modify these later)
            foreach ($quotation->details as $detail) {
                $jobOrder->items()->create([
                    'name' => $detail->item_name,
                    'description' => $detail->description,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->unit_price,
                    'total' => $detail->total,
                ]);
            }
        }
    }
}