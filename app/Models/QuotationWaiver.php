<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationWaiver extends Model
{
    use HasFactory;

    protected $table = 'quotation_waivers';

    protected $fillable = [
        'quotation_id',
        'waiver_title',
        'waiver_description',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function cases()
    {
        return $this->hasMany(WaiverCase::class, 'waiver_id');
    }
}
