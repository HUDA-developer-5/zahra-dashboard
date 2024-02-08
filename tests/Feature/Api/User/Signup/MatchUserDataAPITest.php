<?php

namespace Tests\Feature\Api\User\Signup;

use App\Enums\User\UserProfileStatusEnum;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MatchUserDataAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // call passport install command
        Artisan::call('passport:install --force');
    }

    // test match user data api unauthenticated
    public function test_match_user_data_api_unauthenticated()
    {
        $response = $this->postJson('/api/v1/user/signup/verify/match', []);
        $response->assertStatus(401);
    }

    // test match user data api method not allowed
    public function test_match_user_data_api_method_not_allowed()
    {
        $response = $this->getJson('/api/v1/user/signup/verify/match');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test match user data api validation error
    public function test_match_user_data_api_validation_error()
    {
        $user = User::factory()->create();
        // acting as user
        $response = $this->actingAs($user)
            ->postJson('/api/v1/user/signup/verify/match');
        $response->assertJsonValidationErrors([
            'national_id',
            'date_of_birth'
        ]);
        // assert json structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'national_id',
                'date_of_birth'
            ]
        ]);
        $response->assertStatus(422);
    }

    // test match user data api with valid data
    public function test_match_user_data_api_with_valid_data()
    {
        // create user with profile
        $user = User::factory()->create([
            'national_id' => $this->faker->randomNumber(9),
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail(),
            'date_of_birth' => $this->faker->date(),
            'password' => $this->faker->password(8),
            'is_verified_from_absher' => true,
        ]);

        $userProfile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'total_risk' => 1,
            'risk_assessment' => [
                'total_risk' => 1
            ]
        ]);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('user_profiles', 1);

        $request = [
            'national_id' => (string)$userProfile->iden,
            'date_of_birth' => (string)$userProfile->date_of_birth,
        ];

        // acting as user
        $response = $this->actingAs($user)
            ->postJson('/api/v1/user/signup/verify/match', $request);
        // assert json structure
        $response->assertJsonStructure([
            'data' => [
                'user',
                'user_profile_status',
                'message',
                'token_type',
                'access_token',
            ],
            'code'
        ]);

        $response->assertJsonPath('data.message', trans('api_v1.verification.user_verified'));
        $response->assertJsonPath('data.user_profile_status', UserProfileStatusEnum::HOME->value);
        $response->assertJsonPath('data.user.national_id', $request['national_id']);
        $response->assertJsonPath('data.user.date_of_birth', $request['date_of_birth']);
        $response->assertStatus(200);
    }
}
