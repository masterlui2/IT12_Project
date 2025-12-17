<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_id',
        'name',
        'contact_number',
        'email',
        'service_location',
        'category',
        'device_type',
        'device_details',
        'issue_description',
        'photo_path',
        'urgency',
        'preferred_schedule',
        'status',
        'referral_source',
        'assigned_technician_id',
        'admin_notes',
    ];

    // RELATIONSHIPS ---------------------------------

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'assigned_technician_id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    // SCOPES ----------------------------------------

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_technician_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function service(){
        return $this->belongsTo(Service::class,'category','name');
    }
}