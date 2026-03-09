<?php

namespace Tests\Feature\Admin;

use App\Models\BlockedIp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpBlockingFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_block_and_unblock_ip_address(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.ipBlocking.store'), [
                'ip_address' => '203.0.113.8',
                'duration_minutes' => 1440,
                'reason' => 'Repeated failed login attempts',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('blocked_ips', [
            'ip_address' => '203.0.113.8',
            'reason' => 'Repeated failed login attempts',
            'blocked_by' => $admin->id,
        ]);

        $blockedIp = BlockedIp::query()->where('ip_address', '203.0.113.8')->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.ipBlocking.destroy', $blockedIp))
            ->assertRedirect();

        $this->assertDatabaseMissing('blocked_ips', [
            'ip_address' => '203.0.113.8',
        ]);
    }

    public function test_admin_cannot_block_their_own_current_ip_address(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->from(route('admin.ipBlocking'))
            ->post(route('admin.ipBlocking.store'), [
                'ip_address' => '203.0.113.10',
                'duration_minutes' => 1440,
                'reason' => 'Accidental self block',
            ])
            ->assertRedirect(route('admin.ipBlocking'))
            ->assertSessionHasErrors('ip_address');

        $this->assertDatabaseMissing('blocked_ips', [
            'ip_address' => '203.0.113.10',
        ]);
    }



    public function test_admin_can_access_ip_blocking_page_even_if_current_ip_is_blocked(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        BlockedIp::query()->create([
            'ip_address' => '203.0.113.12',
            'duration_minutes' => 1440,
            'blocked_at' => now(),
            'expires_at' => now()->addDay(),
        ]);

        $this->actingAs($admin)
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.12'])
            ->get(route('admin.ipBlocking'))
            ->assertOk();
    }

    public function test_blocked_ip_is_denied_access(): void
    {
        BlockedIp::query()->create([
            'ip_address' => '203.0.113.9',
            'blocked_at' => now(),
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->get(route('home'))
            ->assertForbidden();
    }
}