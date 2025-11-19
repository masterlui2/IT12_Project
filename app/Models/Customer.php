<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quotation;
class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'contact_number',
        'tin_number',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

}
