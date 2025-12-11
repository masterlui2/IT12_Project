<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'technician_id',
        'customer_name',
        'contact_number',
        'device_type',
        'issue_description',
        'diagnostic_fee',
        'materials_cost',
        'professional_fee',
        'downpayment',
        'balance',
        'expected_finish_date',
        'remarks',
        'materials_specifications',
        'status',
    ];

    protected $casts = [
        'expected_finish_date' => 'date',
        'diagnostic_fee' => 'decimal:2',
        'materials_cost' => 'decimal:2',
        'professional_fee' => 'decimal:2',
        'downpayment' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    // RELATIONSHIPS ---------------------------------
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    // COMPUTED --------------------------------------
    public function getTotalCostAttribute()
    {
        return $this->diagnostic_fee + $this->materials_cost + $this->professional_fee;
    }

    public function getFormattedTotalCostAttribute()
    {
        return '₱' . number_format((float) $this->total_cost, 2);
    }

    public function getFormattedBalanceAttribute()
    {
        return '₱' . number_format((float) $this->balance, 2);
    }

    // STATUS HELPERS --------------------------------
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
        $this->update(['status' => 'completed']);
    }

    public function items() {
        return $this->hasMany(JobOrderItem::class);
    }
}
