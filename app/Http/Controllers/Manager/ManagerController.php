<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class ManagerController extends Controller
{
    public function dashboard(){
        return view('manager.dashboard');
    }

    public function quotation(){
        return view('manager.quotation');
    }

        public function inquiries()
    {
        // Fetch all inquiries and related user data
        $inquiries = Inquiry::orderByDesc('created_at')->paginate(10);

        // Stats for display panels
        $stats = [
            'inquiries' => [
                'unassigned' => $inquiries->whereNull('technician_id')->count(),
                'assigned'   => $inquiries->where('status', 'open')->count(),
                'scheduled'  => $inquiries->where('status', 'scheduled')->count(),
                'converted'  => $inquiries->where('status', 'converted')->count(),
            ],
        ];

        return view('manager.inquiries', compact('inquiries', 'stats'));
    }

    public function inquireShow(int $id){
        $inq = Inquiry::findOrFail($id);
        return redirect()->route('manager.inquiries')
            ->with('status', 'Viewing inquiry INQ-'.$inq->id);
    }

    public function inquireDestroy(int $id){
        $inq = Inquiry::findOrFail($id);
        $inq->delete();
        return redirect()->route('manager.inquiries')
            ->with('status', 'Inquiry INQ-'.$id.' deleted');
    }

    public function services(){
        return view('manager.services');
    }
    public function technicians(){
        return view('manager.technicians');
    }
    public function customers(){
        return view('manager.customers');
    }
    public function reports(){
        return view('manager.reports');
    }    
}
