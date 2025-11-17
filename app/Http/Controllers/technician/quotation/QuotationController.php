<?php

namespace App\Http\Controllers\Technician\Quotation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotationController extends Controller
{
    public function newQuotation(){
        return view('technician.contents.quotations.create');
    }
}
