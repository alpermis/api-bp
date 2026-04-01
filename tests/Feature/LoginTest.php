<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Testler için sabit config değerleri
        config()->set('api.user', 'test-user');
        config()->set('api.pass', 'test-pass');
        config()->set('api.jwt_secret', 'test-jwt-secret');
    }

    public function test_login_success_with_valid_credentials(): void
    {
        $response = $this->postJson('/v1/login', [
            'username' => 'test-user',
            'password' => 'test-pass',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'error'   => null,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'expires',
                ],
                'error',
            ]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/v1/login', [
            'username' => 'wrong-user',
            'password' => 'wrong-pass',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_login_fails_with_missing_fields(): void
    {
        $response = $this->postJson('/v1/login', []);

        $response->assertStatus(422) // validation error
        ->assertJsonValidationErrors(['username', 'password']);
    }
}
