<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'reason',
         'duration_minutes',
        'blocked_by',
        'blocked_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'blocked_at' => 'datetime',
             'expires_at' => 'datetime',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }
}