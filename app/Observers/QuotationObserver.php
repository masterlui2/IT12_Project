<?php

namespace App\Observers;

use App\Models\Quotation;
use App\Models\JobOrder;

class QuotationObserver
{
    public function updated(Quotation $quotation): void
    {
        if ($quotation->isDirty(attributes: 'status') && $quotation->status === 'approved') {
            JobOrder::create([
                'quotation_id' => $quotation->id,
                'technician_id' => $quotation->technician_id,
                'customer_name' => $quotation->client_name,
                'contact_number' => $quotation->inquiry->contact_number ?? null,
                'device_type' => $quotation->inquiry->device_details ?? null,
                'issue_description' => $quotation->inquiry->issue_description ?? null,
                'diagnostic_fee' => $quotation->diagnostic_fee,
                'materials_cost' => $quotation->parts_estimate ?? 0,
                'professional_fee' => $quotation->labor_estimate ?? 0,
                'expected_finish_date' => now()->addDays($quotation->timeline_max_days ?? 5),
                'status' => 'scheduled',
            ]);
        }
    }
}
