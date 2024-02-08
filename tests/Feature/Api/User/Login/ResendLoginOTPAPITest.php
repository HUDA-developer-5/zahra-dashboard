<?php

namespace Tests\Feature\Api\User\Login;

use App\Constants\SystemConstants;
use App\Enums\User\UserStatusEnum;
use App\Interfaces\Messaging\MessagingProviderInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResendLoginOTPAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install --force');
    }

    // test resend otp api unauthorized
    public function test_resend_otp_api_unauthorized()
    {
        $response = $this->postJson('api/v1/user/login/resend-otp');
        $response->assertStatus(401);
        $response->assertUnauthorized();
    }

    // test resend otp api method not allowed
    public function test_resend_otp_api_method_not_allowed()
    {
        $response = $this->getJson('api/v1/user/login/resend-otp');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test resend otp api user not allowed to resend otp
    public function test_resend_otp_api_user_not_allowed_to_resend_otp()
    {
        Passport::actingAs(User::factory()->create(), [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]);
        $response = $this->postJson('api/v1/user/login/resend-otp');
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

    // test resend otp api user allowed to resend otp
    public function test_resend_otp_api_user_allowed_to_resend_otp()
    {
        Passport::actingAs(
            User::factory()->create([
                'status' => UserStatusEnum::ACTIVE->value,
                'is_verified_from_absher' => true,
                'is_data_matched' => true
            ]),
            [SystemConstants::SHORT_LIFE_USER_TOKEN_FOR_OTP]
        );

        // mock MessagingProviderInterface sendSMS method
        $mock = \Mockery::mock(MessagingProviderInterface::class);
        $mock->shouldReceive('sendSMS')
            ->andReturn(true);

        $this->app->instance(MessagingProviderInterface::class, $mock);

        $response = $this->postJson('api/v1/user/login/resend-otp');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'message',
                'uuid',
            ],
            'code'
        ]);

        $response->assertJsonPath('data.message', trans('api_v1.verification_code.verification_code_sent_successfully'));
    }
}
