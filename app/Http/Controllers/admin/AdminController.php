<?php

namespace App\Http\Controllers\Admin;
use App\Models\AuditLog;
use App\Support\AuditSeverity;
use Carbon\Carbon;
use Illuminate\Http\Request;use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class AdminController extends Controller
{
     private function ensureAdmin(): void
{
    abort_unless(Auth::check() && Auth::user()->role === 'admin', 403, 'Unauthorized');
}
   private const MAX_EXPORT_DAYS = 31;
    private const MAX_EXPORT_ROWS = 5000;

    public function dashboard()
    {
 $this->ensureAdmin();

        return view('admin.contents.dashboard');    }

    public function systemManagement(){
        $this->ensureAdmin();

        return view('admin.contents.system-management');
    }
    

    
    public function userAccess(){
           
        $this->ensureAdmin();

        return view('admin.contents.users-access');
    }
    
   public function activity(Request $request){
       $query = AuditLog::with('user')->latest();

        $filters = [
            'search' => trim((string) request('search', '')),
            'level' => trim((string) request('level', '')),
            'date_from' => trim((string) request('date_from', '')),
            'date_to' => trim((string) request('date_to', '')),
        ];

        if ($filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($auditQuery) use ($search) {
                $auditQuery->where('action', 'like', "%{$search}%")
                    ->orWhereRaw('CAST(meta AS CHAR) like ?', ["%{$search}%"])
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(COALESCE(firstname, ''), ' ', COALESCE(lastname, '')) like ?", ["%{$search}%"]);
                    });
            });
        }

        if ($filters['level'] !== '') {
            $level = strtolower($filters['level']);

            if (Schema::hasColumn('audit_logs', 'level')) {
                $query->where('level', $level);
            } else {
                $query->where(function ($auditQuery) use ($level) {
                    $auditQuery->where('action', 'like', "%{$level}%")
                        ->orWhereRaw('CAST(meta AS CHAR) like ?', ["%{$level}%"]);
                });
            }
        }

        if ($filters['date_from'] !== '') {
            $query->where('created_at', '>=', Carbon::parse($filters['date_from'])->startOfDay());
        }

        if ($filters['date_to'] !== '') {
            $query->where('created_at', '<=', Carbon::parse($filters['date_to'])->endOfDay());
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('admin.contents.activity-log', [
            'logs' => $logs,
            'filters' => $filters,
        ]);
   }
      public function analytics(){
           
        $this->ensureAdmin();

        return view('admin.contents.analytics');
    }

    public function developerTools(){
           
        $this->ensureAdmin();

        return view('admin.contents.developer-tools');
    }

    public function documentation(){
           
        $this->ensureAdmin();

        return view('admin.contents.documentation');
    }
}
