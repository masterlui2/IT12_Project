<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrderItem extends Model {
    protected $fillable = [
        'job_order_id', 'name', 'description', 'unit_price', 'quantity', 'total'
    ];

    public function jobOrder() {
        return $this->belongsTo(JobOrder::class);
    }
}
