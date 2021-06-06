<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function createUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->password(8)),
        ];

        return $user = User::create($userData);
    }

    public function test_logout_success()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;


        $response = $this->actingAs($user)->postJson('/api/auth/logout');
        $response->assertStatus(204);
    }
}
