<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationSignature extends Model
{
    use HasFactory;

    protected $table = 'quotation_signatures';

    protected $fillable = [
        'quotation_id',
        'customer_name',
        'customer_signature',
        'customer_date',
        'provider_name',
        'provider_signature',
        'provider_date',
    ];

    protected $casts = [
        'customer_date' => 'date',
        'provider_date' => 'date',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
