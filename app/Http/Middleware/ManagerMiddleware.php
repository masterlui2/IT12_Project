<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Not logged in OR not a manager → block
        if (!Auth::check() || Auth::user()->role !== 'manager') {
            abort(403, 'Unauthorized');
            // or: return redirect()->route('login');
        }

        return $next($request);
    }
}
