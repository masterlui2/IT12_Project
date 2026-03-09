<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        config()->set('services.recaptcha.site_key', 'test-site-key');

        $response = $this->get(route('register'));

        $response->assertStatus(200)
            ->assertSee('g-recaptcha', false)
            ->assertSee('Password must be at least 12 characters', false);
    }

    public function test_new_users_can_register(): void
    {
        config()->set('services.recaptcha.site_key', 'test-site-key');
        config()->set('services.recaptcha.secret_key', 'test-secret-key');

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $response = $this->post(route('register.store'), [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'birthday'              => '1990-01-01',
            'email'                 => 'test@example.com',
            'password'              => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
            'g-recaptcha-response'  => 'test-captcha-token',
        ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }
}