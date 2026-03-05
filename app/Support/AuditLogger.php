<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(string $action, array $meta = [], ?int $userId = null): void
    {
        $request = request();

        AuditLog::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'meta' => $meta,
        ]);
    }
}