<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'certifications',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function getNameAttribute()
    {
        if ($this->user) {
            return trim("{$this->user->firstname} {$this->user->lastname}");
        }
        return null;
    }

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }
}
