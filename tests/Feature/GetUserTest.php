<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserTest extends TestCase
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

    public function test_get_user_success_with_valid_token(): void
    {
        // Önce login olup token alıyoruz
        $loginResponse = $this->postJson('/v1/login', [
            'username' => 'test-user',
            'password' => 'test-pass',
        ]);

        $loginResponse->assertStatus(200);

        $token = $loginResponse->json('data.token');

        // Sonra bu token ile /user endpoint'ine gidiyoruz
        $response = $this->getJson('/v1/user', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'error'   => null,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'name',
                    'email',
                    'role',
                ],
                'error',
            ]);
    }

    public function test_get_user_fails_without_token(): void
    {
        $response = $this->getJson('/v1/user');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_get_user_fails_with_invalid_token(): void
    {
        $response = $this->getJson('/v1/user', [
            'Authorization' => 'Bearer invalid-token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }
}
