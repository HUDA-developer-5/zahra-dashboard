<?php

namespace Tests\Feature\Api\User\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowUserProfileAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install --force');
    }

    // test show user profile api method not allowed
    public function test_show_user_profile_api_method_not_allowed()
    {
        $response = $this->json('POST', '/api/v1/user/profile/show');
        $response->assertStatus(405);
    }

    // test show user profile api with unauthenticated user
    public function test_show_user_profile_api_with_unauthenticated_user()
    {
        $response = $this->json('GET', '/api/v1/user/profile/show');
        $response->assertStatus(401);
    }

    // test show user profile api with authenticated user
    public function test_show_user_profile_api_with_authenticated_user()
    {
        $response = $this->actingAs(User::factory()->create())
            ->json('GET', '/api/v1/user/profile/show');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user'
            ],
            'code',
        ]);
    }
}
