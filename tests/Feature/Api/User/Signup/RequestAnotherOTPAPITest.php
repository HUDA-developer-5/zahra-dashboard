<?php

namespace Tests\Feature\Api\User\Signup;

use App\DTOs\Screening\ReturnHTTPScreeningRequestDTO;
use App\Enums\User\UserProfileStatusEnum;
use App\Enums\Verification\ScreeningRequestProviderEnum;
use App\Enums\Verification\ScreeningRequestStatusEnum;
use App\Enums\Verification\ScreeningRequestTypesEnum;
use App\Models\User;
use App\Services\Api\V1\Screening\Providers\Focal\FocalHttpRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RequestAnotherOTPAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install --force');
    }

    // check request another otp api method not allowed
    public function test_request_another_otp_api_method_not_allowed()
    {
        $response = $this->postJson('/api/v1/user/signup/verify/request-otp');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // check request another otp api unauthenticated
    public function test_request_another_otp_api_unauthenticated()
    {
        $response = $this->getJson('/api/v1/user/signup/verify/request-otp');
        $response->assertStatus(401);
    }

    // check request another otp api happy path
    public function test_request_another_otp_api_happy_path()
    {
        $user = User::factory()->create();
        // create mock for FocalHttpRequestService class
        $this->mockFocalHttpRequestService($user);

        $response = $this->actingAs($user)->getJson('/api/v1/user/signup/verify/request-otp');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'data' => [
                'user',
                'user_profile_status',
                'message',
                'token_type',
                'access_token'
            ]
        ]);

        $response->assertJsonPath('data.message', trans('api_v1.verification.otp_sent_successfully'));
        $response->assertJsonPath('data.user_profile_status', UserProfileStatusEnum::IDENTITY_VERIFICATION->value);
        $this->assertDatabaseHas('screening_requests', [
            'national_id' => $user->national_id,
            'provider' => ScreeningRequestProviderEnum::FOCAL->value,
            'status' => ScreeningRequestStatusEnum::PENDING->value,
            'type' => ScreeningRequestTypesEnum::YAKEEN_OTP->value
        ]);
    }

    // mock FocalHttpRequestService class
    private function mockFocalHttpRequestService(User $user)
    {
        $mock = \Mockery::mock(FocalHttpRequestService::class);
        $mock->shouldReceive('sentOTP')
            ->andReturn(
                ReturnHTTPScreeningRequestDTO::from([
                    'response_status_code' => 200,
                    'request_data' => [
                        'national_id' => $user->national_id,
                        'phone_number' => $user->phone_number,
                    ],
                    'response_data' => [
                        'status' => 'success',
                        'message' => 'OTP sent successfully',
                        'data' => [
                            'request_id' => '123456789',
                            'otp_reference' => '123456789',
                            'otp_expiry' => '2021-09-30 00:00:00',
                        ]
                    ]
                ])
            );

        $this->app->instance(FocalHttpRequestService::class, $mock);
    }
}
