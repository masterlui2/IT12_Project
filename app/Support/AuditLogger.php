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

    public static function logAuthAttempt(string $action, ?string $identifier, string $reason, ?int $userId = null, array $meta = []): void
    {
        self::log($action, array_merge([
            'attempted_identifier' => self::maskIdentifier($identifier),
            'reason' => $reason,
        ], $meta), $userId);
    }

    public static function maskIdentifier(?string $identifier): ?string
    {
        if (blank($identifier)) {
            return null;
        }

        if (str_contains($identifier, '@')) {
            [$localPart, $domain] = explode('@', $identifier, 2);
            $visibleLocal = mb_substr($localPart, 0, 2);

            return $visibleLocal.str_repeat('*', max(0, mb_strlen($localPart) - 2)).'@'.$domain;
        }

        $visiblePrefix = mb_substr($identifier, 0, 2);

        return $visiblePrefix.str_repeat('*', max(0, mb_strlen($identifier) - 2));
    }
}