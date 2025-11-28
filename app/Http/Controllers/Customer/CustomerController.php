<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function track(){
        return view('customer.track-repair');
    }

    public function messages(){
        return view('customer.messages');
    }
}