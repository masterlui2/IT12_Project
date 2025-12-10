<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTemplateScopeCase extends Model
{
    protected $fillable = ['scope_id', 'case_title', 'case_description'];

    public function scope()
    {
        return $this->belongsTo(ServiceTemplateScope::class, 'scope_id');
    }
}
