<?php

namespace Tests\Feature\Auth;

use App\Models\AuditLog;
use App\Models\User;
use App\Support\AuditLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class AuthAuditLoggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_failed_fortify_login_is_audited_with_invalid_credentials_reason(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrorsIn('email');

        $audit = AuditLog::where('action', 'auth.login.failed')->latest('id')->first();

        $this->assertNotNull($audit);
        $this->assertSame('invalid_credentials', $audit->meta['reason'] ?? null);
        $this->assertSame(AuditLogger::maskIdentifier($user->email), $audit->meta['attempted_identifier'] ?? null);
        $this->assertNotNull($audit->ip_address);
        $this->assertNotNull($audit->user_agent);
    }

    public function test_throttled_fortify_login_is_audited_with_throttled_reason(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 6) as $attempt) {
            $this->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'auth.login.failed',
        ]);

        $this->assertTrue(
            AuditLog::where('action', 'auth.login.failed')
                ->get()
                ->contains(fn (AuditLog $log) => ($log->meta['reason'] ?? null) === 'throttled')
        );
    }

    public function test_successful_fortify_login_is_audited(): void
    {
        $user = User::factory()->withoutTwoFactor()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $audit = AuditLog::where('action', 'auth.login.succeeded')->latest('id')->first();

        $this->assertNotNull($audit);
        $this->assertSame('authenticated', $audit->meta['reason'] ?? null);
        $this->assertSame($user->id, $audit->user_id);
        $this->assertSame(AuditLogger::maskIdentifier($user->email), $audit->meta['attempted_identifier'] ?? null);
    }

    public function test_social_callback_failures_are_audited(): void
    {
        $provider = \Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->andThrow(new \Exception('Provider rejected callback'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('login'));

        $audit = AuditLog::where('action', 'auth.login.failed')->latest('id')->first();

        $this->assertNotNull($audit);
        $this->assertSame('social_provider_error', $audit->meta['reason'] ?? null);
        $this->assertSame('google', $audit->meta['provider'] ?? null);
    }
}
