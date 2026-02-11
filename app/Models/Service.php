<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'diagnostic_fee',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'diagnostic_fee' => 'decimal:2', // Cast to decimal with 2 places for consistency
    ];

    // If you don't want timestamps, you can set this to false:
    // public $timestamps = false; 
    // However, your schema includes created_at and updated_at, so it's usually true by default.

    public function inquiries()
    {
        // A Service has many Inquiries, where Service.name matches Inquiry.category
        return $this->hasMany(Inquiry::class, 'category', 'name');
    }
}

