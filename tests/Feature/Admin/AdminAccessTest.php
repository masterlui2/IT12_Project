<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_route_names_remain_unchanged(): void
    {
        $this->assertSame('admin/activity-logs', Route::getRoutes()->getByName('admin.activity')?->uri());
        $this->assertSame('admin/dashboard', Route::getRoutes()->getByName('admin.dashboard')?->uri());
        $this->assertSame('admin/system-management', Route::getRoutes()->getByName('admin.systemManagement')?->uri());
        $this->assertSame('admin/user-access', Route::getRoutes()->getByName('admin.userAccess')?->uri());
        $this->assertSame('admin/analytics', Route::getRoutes()->getByName('admin.analytics')?->uri());
        $this->assertSame('admin/devtools', Route::getRoutes()->getByName('admin.developerTools')?->uri());
        $this->assertSame('admin/documentation', Route::getRoutes()->getByName('admin.documentation')?->uri());
    }

    public function test_guests_are_redirected_to_login_for_admin_routes(): void
    {
        $response = $this->get(route('admin.activity'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_users_are_blocked_from_admin_routes(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer);

        $response = $this->get(route('admin.activity'));

        $response->assertForbidden();
    }

    public function test_admin_users_can_access_admin_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('admin.activity'));

        $response->assertOk();
    }
}
