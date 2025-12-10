<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplateWaiver extends Model
{
    protected $fillable = [
        'template_id',
        'waiver_title',
        'waiver_description',
    ];

    public function template()
    {
        return $this->belongsTo(ServiceTemplate::class, 'template_id');
    }

    public function cases()
    {
        return $this->hasMany(ServiceTemplateWaiverCase::class, 'waiver_id');
    }
}
