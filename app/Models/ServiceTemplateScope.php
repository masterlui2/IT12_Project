<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplateScope extends Model
{
    protected $fillable = ['template_id', 'scenario_name', 'description'];

    public function template()
    {
        return $this->belongsTo(ServiceTemplate::class, 'template_id');
    }

    public function cases()
    {
        return $this->hasMany(ServiceTemplateScopeCase::class, 'scope_id');
    }
}
