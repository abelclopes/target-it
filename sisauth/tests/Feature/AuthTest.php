<?php
// tests/Feature/AuthTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        // Crie um usuário para testes
        $this->user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'invalid_password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Unauthorized']);
    }

    public function test_user_can_logout()
    {
        // Primeiro faça login
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $token = $loginResponse->json('access_token');

        // Depois faça logout
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}
