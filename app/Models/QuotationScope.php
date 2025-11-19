<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationScope extends Model
{
    use HasFactory;

    protected $table = 'quotation_scope';

    protected $fillable = [
        'quotation_id',
        'scenario_name',
        'description',
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
        return $this->hasMany(QuotationCase::class, 'scope_id');
    }
}
