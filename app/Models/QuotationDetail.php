<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    use HasFactory;

    protected $table = 'quotation_details';

    protected $fillable = [
        'quotation_id',
        'item_name',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function getComputedTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getFormattedTotalAttribute()
    {
        return '₱' . number_format($this->total ?? $this->computed_total, 2);
    }
}
