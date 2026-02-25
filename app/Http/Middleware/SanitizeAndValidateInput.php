<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeAndValidateInput
{
    /**
     * Keys where rich text is expected and should not be stripped.
     *
     * @var array<int, string>
     */
    protected array $skipTagStripFor = [];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sanitized = $this->sanitizeValue($request->all());

        if ($this->containsSqlInjectionPattern($sanitized)) {
            abort(422, 'Input contains unsafe SQL patterns.');
        }

        $request->merge($sanitized);

        return $next($request);
    }

    /**
     * Recursively sanitize user input values.
     *
     * @param  mixed  $value
     * @param  string|null  $key
     * @return mixed
     */
    protected function sanitizeValue(mixed $value, ?string $key = null): mixed
    {
        if (is_array($value)) {
            $clean = [];

            foreach ($value as $nestedKey => $nestedValue) {
                $clean[$nestedKey] = $this->sanitizeValue(
                    $nestedValue,
                    is_string($nestedKey) ? $nestedKey : $key
                );
            }

            return $clean;
        }

        if (! is_string($value)) {
            return $value;
        }

        $sanitized = trim($value);
        $sanitized = preg_replace('/[\x00-\x1F\x7F]/u', '', $sanitized) ?? $sanitized;

        if (! in_array($key, $this->skipTagStripFor, true)) {
            $sanitized = strip_tags($sanitized);
        }

        return $sanitized;
    }

    /**
     * Detect common SQL injection signatures recursively.
     *
     * @param  mixed  $value
     */
    protected function containsSqlInjectionPattern(mixed $value): bool
    {
        if (is_array($value)) {
            foreach ($value as $nestedValue) {
                if ($this->containsSqlInjectionPattern($nestedValue)) {
                    return true;
                }
            }

            return false;
        }

        if (! is_string($value)) {
            return false;
        }

        $patterns = [
            '/\bunion\s+select\b/i',
            '/\binsert\s+into\b/i',
            '/\bupdate\s+\w+\s+set\b/i',
            '/\bdelete\s+from\b/i',
            '/\bdrop\s+table\b/i',
            '/--/',
            '/\/\*/',
            '/\*\//',
            '/\bor\s+1\s*=\s*1\b/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value) === 1) {
                return true;
            }
        }

        return false;
    }
}
