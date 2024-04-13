<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_post(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('welcome.users.destroy', ['id' => $user->id]), [
            '_token' => csrf_token(),
        ]);

        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
