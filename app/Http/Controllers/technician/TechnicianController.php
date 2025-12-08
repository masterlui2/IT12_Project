<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
class TechnicianController extends Controller
{
    public function dashboard(){
        return view('technician.contents.dashboard');
    }

   public function messages(Request $request)
    {
        $customerThreads = Message::with('user')
            ->whereHas('user', fn ($query) => $query->where('role', 'customer'))
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(function ($messages) {
                $latest = $messages->first();

                return (object) [
                    'user' => $latest?->user,
                    'latest_message' => $latest,
                    'count' => $messages->count(),
                ];
            })
            ->sortByDesc(fn ($thread) => optional($thread->latest_message)->created_at);

        $activeCustomerId = $request->integer('customer_id') ?: $customerThreads->keys()->first();
        $activeCustomer = $activeCustomerId ? optional($customerThreads->get($activeCustomerId))->user : null;
        $activeInquiry = null;

        $messages = collect();

        if ($activeCustomerId) {
            $activeInquiry = Inquiry::where('customer_id', $activeCustomerId)
                ->latest()
                ->first();

            $messages = Message::with('user')
                ->whereIn('user_id', [$activeCustomerId, Auth::id()])
                ->orderBy('created_at')
                ->get();
        }

        return view('technician.contents.messages', [
            'messages' => $messages,
            'customerThreads' => $customerThreads,
            'activeCustomer' => $activeCustomer,
            'activeCustomerId' => $activeCustomerId,
            'activeInquiry' => $activeInquiry,
        ]);
        }

    public function reporting(){
        return view('technician.contents.reporting');
    }

    public function inquire()
    {
        // Get the current technician record linked to the user
        $technician = Auth::user()->technician;

        $inquiries = Inquiry::where(function ($q) use ($technician) {
                $q->whereNull('assigned_technician_id')
                ->orWhereIn('assigned_technician_id', [optional($technician)->id, Auth::id()]);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('technician.contents.inquiries.index', compact('inquiries'));
    }

    public function claim($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Prevent re-claiming if already assigned
        if ($inquiry->assigned_technician_id) {
            return redirect()->back()->with('error', 'This inquiry is already claimed.');
        }

        // Authenticated user hasOne Technician
        $technician = Auth::user()->technician;

        if (! $technician) {
            return redirect()->back()->with('error', 'You are not registered as a technician.');
        }

        $inquiry->assigned_technician_id = $technician->id; // ✅ use technician ID
        $inquiry->status = 'Acknowledged';
        $inquiry->save();

        return redirect()->route('technician.inquire.index')
            ->with('success', 'Inquiry INQ-' . str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) . ' claimed successfully.');
    }

    public function inquireShow(int $id)
    {
        // Fetch inquiry with necessary relationships
        $inquiry = Inquiry::with('technician', 'customer')->findOrFail($id);

        // Render technician detail view
        return view('technician.contents.inquiries.show', compact('inquiry'));
    }

    public function inquireDestroy(int $id){
        $inq = Inquiry::findOrFail($id);
        $inq->delete();
        return redirect()->route('technician.inquire.index')
            ->with('status', 'Inquiry INQ-'.$id.' deleted');
    }

    public function history(){
        return view('technician.contents.history');
    }
}
