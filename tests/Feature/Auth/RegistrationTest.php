<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200)
            ->assertSee('human_check', false)
            ->assertSee('I am not a robot', false)
            ->assertSee('Password must be at least 12 characters', false);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post(route('register.store'), [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'birthday'              => '1990-01-01',
            'email'                 => 'test@example.com',
            'password'              => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
            'human_check'           => '1', // simulates checkbox being checked
        ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_registration_fails_without_human_check(): void
    {
        $response = $this->post(route('register.store'), [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'birthday'              => '1990-01-01',
            'email'                 => 'test@example.com',
            'password'              => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
            // human_check intentionally omitted
        ]);

        $response->assertSessionHasErrors(['human_check']);
        $this->assertGuest();
    }
}