<?php
// ============================================
// App\Models\Quotation.php
// ============================================
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

    // ✅ Changed from hasOne to hasMany
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    // ✅ Keep this for backwards compatibility (gets the first/latest job order)
    public function jobOrder()
    {
        return $this->hasOne(JobOrder::class)->latestOfMany();
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

    // ✅ Helper method to check if quotation has been converted to job order
    public function hasJobOrder()
    {
        return $this->jobOrders()->exists();
    }
}

// ============================================
// App\Models\JobOrder.php
// ============================================
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'technician_id',
        'start_date',
        'expected_finish_date',
        'timeline_min_days',
        'timeline_max_days',
        'technician_notes',
        'status',
        'completed_at',
        'subtotal',
        'downpayment',
        'total_amount',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_finish_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function items()
    {
        return $this->hasMany(JobOrderItem::class);
    }

    // Status helpers
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}