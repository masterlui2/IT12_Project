<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quotation;
class Customer extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

}
