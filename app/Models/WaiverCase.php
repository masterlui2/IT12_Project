<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiverCase extends Model
{
    use HasFactory;

    protected $table = 'waiver_cases';

    protected $fillable = [
        'waiver_id',
        'case_title',
        'description',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    public function waiver()
    {
        return $this->belongsTo(QuotationWaiver::class, 'waiver_id');
    }
}
