<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Customer Info
        'customer_id',
        'name',
        'contact_number',
        'email',
        'service_location',

        // Service Details
        'category',
        'device_details',
        'issue_description',
        'photo_path',

        // Schedule & Priority
        'urgency',
        'preferred_schedule',

        // Tracking & Marketing
        'status',
        'referral_source',

        // Admin Assignment
        'assigned_technician_id',
        'admin_notes',
    ];

    /**
     * Relationships
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedTechnician()
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_technician_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
