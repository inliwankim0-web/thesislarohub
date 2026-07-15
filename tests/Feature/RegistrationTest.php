<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_is_disabled_for_ui_only_deployment(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'email' => 'juan@example.com',
            'contact' => '09171234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => 'on',
        ]);

        $response->assertRedirect(route('register'));
        $this->assertDatabaseMissing('users', [
            'email' => 'juan@example.com',
        ]);
        $this->assertGuest();
    }
}
