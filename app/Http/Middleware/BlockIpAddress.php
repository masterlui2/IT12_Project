<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class BlockIpAddress
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()?->role === 'admin') {
            return $next($request);
        }
        $ipAddress = (string) $request->ip();

      if ($ipAddress !== '') {
            BlockedIp::query()
                ->where('ip_address', $ipAddress)
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', now())
                ->delete();

            $isBlocked = BlockedIp::query()
                ->where('ip_address', $ipAddress)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->exists();

            if ($isBlocked) {
                abort(403, 'Access denied. Your IP address has been blocked by the administrator.');
            }
        }

        return $next($request);
    }
}