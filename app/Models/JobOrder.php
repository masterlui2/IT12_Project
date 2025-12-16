<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'quotation_id',
    'technician_id',
    'start_date',
    'expected_finish_date',
    'timeline_min_days',
    'timeline_max_days',
    'technician_notes',
    'status',
    'completed_at',
];

 
    protected $casts = [
        'start_date' => 'date',
        'expected_finish_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function items()
    {
        return $this->hasMany(JobOrderItem::class);
    }

    // Status helpers
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
