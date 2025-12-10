<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplateWaiverCase extends Model
{
    protected $fillable = [
        'waiver_id',
        'case_title',
        'description',
    ];

    public function waiver()
    {
        return $this->belongsTo(ServiceTemplateWaiver::class, 'waiver_id');
    }
}
