<?php

// tests/Feature/UserTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_user()
    {
        // Usando a factory diretamente pelo namespace completo
        $user = \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
}

