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
                'technician_id' => null,
                'expected_finish_date' => now()->addDays($quotation->timeline_max_days ?? 5),
                'status' => 'scheduled',
            ]);
        }
    }
}