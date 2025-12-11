<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplate extends Model
{
    protected $fillable = ['name', 'category', 'description', 'is_active'];

    public function scopes()
    {
        return $this->hasMany(ServiceTemplateScope::class, 'template_id');
    }

    public function waivers()
    {
        return $this->hasMany(ServiceTemplateWaiver::class, 'template_id');
    }

    public function deliverables()
    {
        return $this->hasMany(ServiceTemplateDeliverable::class, 'template_id');
    }
}
