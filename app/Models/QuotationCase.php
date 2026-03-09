<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationCase extends Model
{
    use HasFactory;

    protected $table = 'quotation_cases';

    protected $fillable = [
        'scope_id',
        'case_title',
        'case_description',
    ];

    // -------------------------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------------------------
    public function scope()
    {
        return $this->belongsTo(QuotationScope::class, 'scope_id');
    }
}
