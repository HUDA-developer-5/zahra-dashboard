<?php

namespace Tests\Feature\Api\User\Logout;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install --force');
    }

    // test logout api method not allowed
    public function test_logout_api_method_not_allowed()
    {
        $response = $this->getJson('api/v1/user/logout');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test logout api with unauthenticated user
    public function test_logout_api_with_unauthenticated_user()
    {
        $response = $this->postJson('api/v1/user/logout');
        $response->assertStatus(401);
        $response->assertUnauthorized();
    }

    // test logout api with authenticated user
    public function test_logout_api_with_authenticated_user()
    {
        $response = $this->actingAs(User::factory()->create())
            ->postJson('api/v1/user/logout');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
        // assert all user token are revoked
        $this->assertDatabaseMissing('oauth_access_tokens', [
            'revoked' => 0
        ]);
    }
}
