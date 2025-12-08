<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplateDeliverable extends Model
{
    protected $fillable = [
        'template_id',
        'deliverable_detail',
    ];

    public function template()
    {
        return $this->belongsTo(ServiceTemplate::class, 'template_id');
    }
}
