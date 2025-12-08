<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'Customer_ID',
        'Job_ID',
        'Comments',
        'rating',
        'category',
        'message',
        'Date_Submitted',
    ];

    protected $casts = [
        'Date_Submitted' => 'datetime',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Customer_ID');
    }

    // Display name accessor
    public function getCustomerNameAttribute(): string
    {
        if (!$this->user) {
            return 'Anonymous user';
        }

        $first = $this->user->firstname ?? '';
        $last  = $this->user->lastname ?? '';
        $full  = trim($first . ' ' . $last);

        if ($full !== '') {
            return $full;
        }

        return $this->user->name ?? 'Anonymous user';
    }
}
