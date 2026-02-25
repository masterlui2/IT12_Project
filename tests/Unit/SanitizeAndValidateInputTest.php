<?php

namespace Tests\Unit;

use App\Http\Middleware\SanitizeAndValidateInput;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class SanitizeAndValidateInputTest extends TestCase
{
    public function test_it_sanitizes_strings_recursively(): void
    {
        $middleware = new SanitizeAndValidateInput();

        $request = Request::create('/test', 'POST', [
            'name' => '  <script>alert(1)</script>Alice  ',
            'nested' => [
                'comment' => "\x00<b>Hello</b>\x1F",
            ],
        ]);

        $response = $middleware->handle($request, function (Request $sanitizedRequest) {
            return response()->json($sanitizedRequest->all());
        });
        /** @var \Illuminate\Http\JsonResponse $response */
            $payload = $response->getData(true);

        $this->assertSame('alert(1)Alice', $payload['name']);
        $this->assertSame('Hello', $payload['nested']['comment']);
    }

    public function test_it_rejects_common_sql_injection_patterns(): void
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionCode(422);

        $middleware = new SanitizeAndValidateInput();

        $request = Request::create('/test', 'POST', [
            'query' => "admin' OR 1=1 --",
        ]);

        $middleware->handle($request, function () {
            return response('ok');
        });
    }
}
