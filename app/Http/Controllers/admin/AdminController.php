<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Inquiry;
use App\Models\JobOrder;
use App\Models\PasswordResetRequest;
use App\Models\Quotation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    private const MAX_EXPORT_DAYS = 31;
    private const MAX_EXPORT_ROWS = 5000;

    /**
     * Ensure the authenticated user is an admin.
     */
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()?->role === 'admin', 403, 'Unauthorized');
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $this->ensureAdmin();

        $userStats = [
            'administrators' => User::where('role', 'admin')->count(),
            'technicians' => User::where('role', 'technician')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'clients' => User::where('role', 'customer')->count(),
        ];

        $systemStats = [
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'open_quotations' => Quotation::whereNotIn('status', ['approved', 'rejected'])->count(),
            'total_revenue' => JobOrder::sum('total_amount') ?? 0,
            'failed_jobs' => DB::table('failed_jobs')->count(),
            'failed_logins_24h' => AuditLog::where('action', 'auth.login.failed')
                ->where('created_at', '>=', now()->subDay())
                ->count(),
            'activity_events_24h' => AuditLog::where('created_at', '>=', now()->subDay())->count(),
        ];

        $recentLogs = AuditLog::with('user')->latest()->take(8)->get();

        $activitySeries = AuditLog::selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->mapWithKeys(fn($item) => [$item->day => $item->total]);

        return view('admin.contents.dashboard', compact(
            'userStats', 
            'systemStats', 
            'recentLogs', 
            'activitySeries'
        ));
    }

    /**
     * Display system management page.
     */
    public function systemManagement()
    {
        $this->ensureAdmin();
        return view('admin.contents.system-management');
    }

    /**
     * Display user access management page.
     */
    public function userAccess()
    {
        $this->ensureAdmin();

        $users = User::query()
            ->latest()
            ->paginate(10, ['*'], 'users_page');

        $roleCounts = User::query()
            ->select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        $passwordResetRequests = PasswordResetRequest::with(['user', 'reviewer'])
            ->latest()
            ->paginate(10, ['*'], 'requests_page');

        return view('admin.contents.users-access', compact(
            'users', 
            'roleCounts', 
            'passwordResetRequests'
        ));
    }

    /**
     * Process and approve a password reset request.
     */
    public function processPasswordResetRequest(Request $request, PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $passwordResetRequest->user 
            ?? User::where('email', $passwordResetRequest->email)->first();

        if (!$user) {
            return back()->withErrors([
                'password_reset' => __('No account was found for this request. Please verify identity details before resetting.'),
            ]);
        }

        DB::transaction(function () use ($user, $validated, $passwordResetRequest) {
            // Update user password
            $user->forceFill(['password' => Hash::make($validated['password'])])->save();

            // Update the reset request
            $passwordResetRequest->update([
                'user_id' => $user->id,
                'status' => 'reset_completed',
                'admin_notes' => $validated['admin_notes'] ?? null,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

            // Log the action
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'admin.password.reset.approved',
                'meta' => [
                    'target_user_id' => $user->id,
                    'target_email' => $user->email,
                    'request_id' => $passwordResetRequest->id,
                ],
            ]);
        });

        return back()->with('status', __('Password was reset successfully for :email.', [
            'email' => $user->email
        ]));
    }

    /**
     * Reject a password reset request.
     */
    public function rejectPasswordResetRequest(Request $request, PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated, $passwordResetRequest) {
            $passwordResetRequest->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'],
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

            // Log the action
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'admin.password.reset.rejected',
                'meta' => [
                    'request_id' => $passwordResetRequest->id,
                    'email' => $passwordResetRequest->email,
                    'reason' => $validated['admin_notes'],
                ],
            ]);
        });

        return back()->with('status', __('Password reset request was rejected.'));
    }

    /**
     * Display activity log with filters.
     */
    public function activity(Request $request)
    {
        $this->ensureAdmin();

        $query = AuditLog::with('user')->latest();

        $filters = [
            'search' => trim((string) $request->input('search', '')),
            'level' => trim((string) $request->input('level', '')),
            'date_from' => trim((string) $request->input('date_from', '')),
            'date_to' => trim((string) $request->input('date_to', '')),
        ];

        // Apply search filter
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

        // Apply level filter if column exists
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

        // Apply date filters
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

    /**
     * Display analytics page.
     */
    public function analytics()
    {
        $this->ensureAdmin();
        return view('admin.contents.analytics');
    }

    /**
     * Display developer tools page.
     */
    public function developerTools()
    {
        $this->ensureAdmin();
        return view('admin.contents.developer-tools');
    }

    /**
     * Display documentation page.
     */
    public function documentation()
    {
        $this->ensureAdmin();
        return view('admin.contents.documentation');
    }
}