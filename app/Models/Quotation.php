<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'technician_id',
        'approved_by',
        'inquiry_id',
        'project_title',
        'date_issued',
        'labor_estimate',
        'parts_estimate',
        'diagnostic_fee',
        'grand_total',
        'status',
        'client_logo',
        'client_name',
        'client_address',
        'objective',
        'timeline_min_days',
        'timeline_max_days',
        'terms_conditions',
    ];

    protected $casts = [
        'date_issued' => 'date',
    ];

    // RELATIONSHIPS ---------------------------------

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function jobOrder()
    {
        return $this->hasOne(JobOrder::class);
    }

    public function details()
    {
        return $this->hasMany(QuotationDetail::class);
    }

    public function scopes()
    {
        return $this->hasMany(QuotationScope::class);
    }

    public function waivers()
    {
        return $this->hasMany(QuotationWaiver::class);
    }

    public function deliverables()
    {
        return $this->hasMany(QuotationDeliverable::class);
    }

    public function signature()
    {
        return $this->hasOne(QuotationSignature::class);
    }

    // COMPUTED ATTRIBUTES ----------------------------

    public function getSubtotalAttribute()
    {
        return $this->details->sum(fn($detail) => $detail->quantity * $detail->unit_price);
    }

    public function getTaxAttribute()
    {
        return $this->subtotal * 0.10;
    }

    public function getTotalAmountAttribute()
    {
        return $this->subtotal + $this->tax;
    }

    public function getFormattedSubtotalAttribute()
    {
        return '₱' . number_format($this->subtotal, 2);
    }

    public function getFormattedTaxAttribute()
    {
        return '₱' . number_format($this->tax, 2);
    }

    public function getFormattedTotalAttribute()
    {
        return '₱' . number_format($this->total_amount, 2);
    }

    public function getTimelineTextAttribute()
    {
        if ($this->timeline_min_days && $this->timeline_max_days) {
            return "{$this->timeline_min_days}‑{$this->timeline_max_days} days";
        }

        return $this->timeline_min_days
            ? "{$this->timeline_min_days} days"
            : 'Not specified';
    }
}
