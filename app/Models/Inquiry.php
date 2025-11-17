<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'name',
    'contact_number',
    'device_type',
    'issue_description',
    'preferred_schedule',
    'status',            // if you track status (e.g. 'new', 'open', etc.)
];

}
