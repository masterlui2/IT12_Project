<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;

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
        $inquiries = Inquiry::orderByDesc('created_at')->paginate(10);
        return view('technician.contents.inquire', compact('inquiries'));
    }

    public function inquireShow(int $id){
        $inq = Inquiry::findOrFail($id);
        return redirect()->route('technician.contents.inquire')
            ->with('status', 'Viewing inquiry INQ-'.$inq->id);
    }

    public function inquireDestroy(int $id){
        $inq = Inquiry::findOrFail($id);
        $inq->delete();
        return redirect()->route('technician.contents.inquire')
            ->with('status', 'Inquiry INQ-'.$id.' deleted');
    }

    public function history(){
        return view('technician.contents.history');
    }
}
