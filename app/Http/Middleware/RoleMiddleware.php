<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Not logged in OR not a manager → block
        if (!Auth::check() || Auth::user()->role !== 'technician') {
            abort(403, 'Unauthorized');
            // or: return redirect()->route('login');
        }

        return $next($request);
    }
}
