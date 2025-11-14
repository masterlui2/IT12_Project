<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function dashboard(){
        return view('technician.contents.dashboard');
    }

    public function quotation(){
        return view('technician.contents.quotation');
    }

    public function messages(){
        return view('technician.contents.messages');
    }

    public function reporting(){
        return view('technician.contents.reporting');
    }

    public function inquire(){
        return view('technician.contents.inquire');
    }

    public function history(){
        return view('technician.contents.history');
    }
}
