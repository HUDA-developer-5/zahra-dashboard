<?php

namespace Tests\Feature\Api\User\Signup;

use App\Enums\User\UserProfileStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthSignUpTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // setup method
    protected function setUp(): void
    {
        parent::setUp();
        // call passport install command
        Artisan::call('passport:install --force');
    }

    // test api signup already exists
    public function test_api_signup_already_exists()
    {
        $response = $this->postJson('/api/v1/user/signup');
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
            'national_id',
            'phone_number',
            'date_of_birth',
            'password'
        ]);

        // assert json structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'national_id',
                'phone_number',
                'date_of_birth',
                'password'
            ]
        ]);
    }

    // test api signup api not allowed
    public function test_api_signup_method_not_allowed()
    {
        $response = $this->getJson('/api/v1/user/signup/validate');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test api validate signup validation national id, email and phone number already exists
    public function test_api_signup_validation_national_id_already_exists()
    {
        $newUserData = $this->userData();
        // create user in database using factory
        User::factory()->create($newUserData);
        $response = $this->postJson('/api/v1/user/signup', $newUserData);
        $response->assertJsonValidationErrors(['national_id', 'email', 'phone_number']);
        $response->assertStatus(422);
    }

    // test api signup validation password is invalid
    public function test_api_signup_validation_password_is_invalid()
    {
        $newUserData = $this->userData();
        $newUserData['password'] = 'string';
        $response = $this->postJson('/api/v1/user/signup', $newUserData);
        $response->assertJsonValidationErrors(['password']);
        $response->assertStatus(422);
    }

    // test api signup with valid data
    public function test_api_signup_with_valid_data()
    {
        $newUserData = $this->userData();
        $response = $this->postJson('/api/v1/user/signup', $newUserData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'national_id',
                    'email',
                    'phone_number',
                    'date_of_birth',
                    'profile_status'
                ],
                'access_token',
                'token_type',
            ],
            'code'
        ]);

        $response->assertJson([
            'data' => [
                'user' => [
                    'national_id' => $newUserData['national_id'],
                    'email' => $newUserData['email'],
                    'phone_number' => $newUserData['phone_number'],
                    'profile_status' => UserProfileStatusEnum::IDENTITY_VERIFICATION->value,
                ],
            ],
        ]);
    }

    private function userData(): array
    {
        return [
            'email' => $this->faker->email,
            'national_id' => '123456789',
            'phone_number' => '+966582014422',
            'date_of_birth' => '1990-1-1',
            'password' => '@Asdf1234wews',
        ];
    }
}
