<?php

namespace Tests\Feature\Api\User\Login;

use App\Constants\SystemConstants;
use App\Enums\User\UserProfileStatusEnum;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Services\Api\V1\Verification\VerificationRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class VerifyLoginOTPAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install --force');
    }

    // test verify otp api unauthorized
    public function test_verify_otp_api_unauthorized()
    {
        $response = $this->postJson('api/v1/user/login/verify-otp');
        $response->assertStatus(401);
        $response->assertUnauthorized();
    }

    // test verify otp api method not allowed
    public function test_verify_otp_api_method_not_allowed()
    {
        $response = $this->getJson('api/v1/user/login/verify-otp');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test verify otp api validation error
    public function test_verify_otp_api_validation_error()
    {
        Passport::actingAs(User::factory()->create(), [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]);
        $response = $this->postJson('api/v1/user/login/verify-otp');
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'uuid',
                'code',
            ],
        ]);
    }

    // test verify otp api user not allowed to verify otp
    public function test_verify_otp_api_user_not_allowed_to_verify_otp()
    {
        Passport::actingAs(User::factory()->create(), [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]);
        $response = $this->postJson('api/v1/user/login/verify-otp', [
            'uuid' => $this->faker->uuid,
            'code' => (string)$this->faker->randomNumber(6),
        ]);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error',
            'code',
        ]);
        $response->assertJson([
            'error' => trans('api_v1.login.you_could_not_login'),
            'code' => 400,
        ]);
    }

    // test verify otp api user with invalid uuid or code
    public function test_verify_otp_api_user_with_invalid_data()
    {
        Passport::actingAs(
            User::factory()->create([
                'status' => UserStatusEnum::ACTIVE->value,
                'is_verified_from_absher' => true,
                'is_data_matched' => true
            ]),
            [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]
        );

        // mock VerificationRequestService verifyOTP method
        $mock = \Mockery::mock(VerificationRequestService::class);
        $mock->shouldReceive('verifyOTP')
            ->andReturn(false);

        $this->app->instance(VerificationRequestService::class, $mock);

        $response = $this->postJson('api/v1/user/login/verify-otp', [
            'uuid' => $this->faker->uuid,
            'code' => (string)$this->faker->randomNumber(6),
        ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            'error',
            'code'
        ]);

        $response->assertJsonPath('error', trans('api_v1.verification_code.invalid_verification_code'));
    }

    // test verify otp api user with valid uuid and code
    public function test_verify_otp_api_user_with_valid_data()
    {
        $verificationRequest = VerificationRequest::factory()->create([
            'mobile' => '966500000000',
            'uuid' => $this->faker->uuid,
            'code' => (string)$this->faker->randomNumber(6),
            'is_used' => false,
            'expire_at' => now()->addMinutes(SystemConstants::VERIFICATION_CODE_EXPIRATION_MINUTES),
            'retries' => 0,
        ]);

        Passport::actingAs(
            User::factory()->create([
                'phone_number' => $verificationRequest->mobile,
                'status' => UserStatusEnum::ACTIVE->value,
                'is_verified_from_absher' => true,
                'is_data_matched' => true
            ]),
            [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]
        );

        $response = $this->postJson('api/v1/user/login/verify-otp', [
            'uuid' => $verificationRequest->uuid,
            'code' => (string)$verificationRequest->code,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'user',
                'token_type',
                'access_token',
            ],
            'code',
        ]);

        $response->assertJsonPath('data.user.profile_status', UserProfileStatusEnum::HOME->value);
    }
}
