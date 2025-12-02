<?php

namespace App\Observers;

use App\Models\Quotation;

class QuotationObserver
{
    /**
     * Handle the Quotation "updated" event.
     */
    public function updated(Quotation $quotation): void
    {
        if ($quotation->status === 'approved' && !$quotation->jobOrder) {
            $inquiry = $quotation->inquiry;

            $quotation->jobOrder()->create([
                'technician_id'     => $quotation->technician_id,
                'customer_name'     => $inquiry?->name ?? $quotation->client_name,
                'contact_number'    => $inquiry?->contact_number ?? 'Unavailable',
                'device_type'       => $inquiry?->device_details ?? 'Not specified',
                'issue_description' => $quotation->objective ?? $inquiry?->issue_description ?? 'No description',
                'diagnostic_fee'    => $quotation->diagnostic_fee,
                'materials_cost'    => $quotation->parts_estimate,
                'professional_fee'  => $quotation->labor_estimate,
                'downpayment'       => 0,
                'balance'           => $quotation->grand_total,
                'expected_finish_date' => now()->addDays($quotation->timeline_max_days ?? 3),
                'status'            => 'scheduled',
            ]);
        }
    }
}
