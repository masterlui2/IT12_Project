<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDeliverable extends Model
{
    use HasFactory;

    protected $table = 'quotation_deliverables';

    protected $fillable = [
        'quotation_id',
        'deliverable_detail',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
