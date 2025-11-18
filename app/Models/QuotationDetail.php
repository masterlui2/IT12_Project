<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // TABLE CONFIGURATION
    // -------------------------------------------------------------------------
    protected $table = 'quotation_details';   // Explicitly naming for clarity

    protected $fillable = [
        'quotation_id',
        'item_name',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    // Each detail belongs to one quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    // -------------------------------------------------------------------------
    // AUTO-CALCULATIONS / ACCESSORS
    // -------------------------------------------------------------------------
    // Automatically get subtotal for this row (if not manually stored)
    public function getComputedTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    // For consistent formatting when rendering amounts
    public function getFormattedTotalAttribute()
    {
        return '₱' . number_format($this->total ?? $this->computed_total, 2);
    }
}
