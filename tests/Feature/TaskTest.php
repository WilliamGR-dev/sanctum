<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskTest extends TestCase
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

    public function test_show_task_unauthorized()
    {
        $response = $this->postJson('/api/tasksuser');

        $response->assertStatus(401);
    }

    public function test_show_task_not_found()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $data = [
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->postJson('/api/tasksuser', $data);

        $response->assertStatus(404);
    }

    public function test_show_task_forbidden()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $data = [
            'user_id' => $this->faker->randomNumber()
        ];

        $response = $this->actingAs($user)->postJson('/api/tasksuser', $data);

        $response->assertStatus(403);
    }

    public function test_show_task_success()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $data = [
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->postJson('/api/tasksuser', $data);

        $response->assertStatus(201);
    }
}
