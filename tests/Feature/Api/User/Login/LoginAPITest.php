<?php

namespace Tests\Feature\Api\User\Login;

use App\Enums\User\UserStatusEnum;
use App\Interfaces\Messaging\MessagingProviderInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginAPITest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install --force');
    }

    public function test_login_api_validation_error()
    {
        $response = $this->postJson('api/v1/user/login', []);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'phone_number',
            'password'
        ]);
    }

    public function test_login_api_method_not_allowed()
    {
        $response = $this->getJson('api/v1/user/login');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test api login with invalid password
    public function test_login_api_with_invalid_password()
    {
        $phoneNumber = phone('512345678', 'SA');
        // create user with valid phone numb
        $user = User::factory()->create([
            'phone_number' => $phoneNumber->formatE164(),
            'password' => 'correct_password'
        ]);
        // login user
        $response = $this->actingAs($user)
            ->postJson('api/v1/user/login', [
                'phone_number' => $user->phone_number,
                'password' => 'incorrect_password'
            ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error',
            'code'
        ]);

        $response->assertJsonPath('error', trans('api_v1.login.invalid_credentials'));
    }

    // test api login with valid password and user status is pending
    public function test_login_api_for_pending_user()
    {
        $phoneNumber = phone('512345678', 'SA');
        // create user
        $user = User::factory()->create([
            'phone_number' => $phoneNumber->formatE164(),
            'password' => 'correct_password'
        ]);
        // login user
        $response = $this->actingAs($user)
            ->postJson('api/v1/user/login', [
                'phone_number' => $user->phone_number,
                'password' => 'correct_password'
            ]);

        $response->assertJsonStructure([
            'data' => [
                'user',
                'message',
                'uuid',
                'token_type',
                'access_token'
            ],
            'code'
        ]);

        $response->assertJsonPath('data.message', trans('api_v1.login.you_logged_in_successfully'));
        $response->assertJsonPath('data.user.id', $user->id);
        $response->assertJsonPath('data.uuid', null);
        $response->assertJsonPath('data.token_type', 'Bearer');
    }

    // test api login with valid password and user status is active
    public function test_login_api_for_active_user()
    {
        $phoneNumber = phone('512345678', 'SA');
        // create user
        $user = User::factory()->create([
            'phone_number' => $phoneNumber->formatE164(),
            'password' => 'correct_password',
            'status' => UserStatusEnum::ACTIVE->value,
            'is_verified_from_absher' => true,
            'is_data_matched' => true
        ]);

        // mock MessagingProviderInterface sendSMS method
        $mock = \Mockery::mock(MessagingProviderInterface::class);
        $mock->shouldReceive('sendSMS')
            ->andReturn(true);

        $this->app->instance(MessagingProviderInterface::class, $mock);

        // login user
        $response = $this->actingAs($user)
            ->postJson('api/v1/user/login', [
                'phone_number' => $user->phone_number,
                'password' => 'correct_password'
            ]);

        $response->assertJsonStructure([
            'data' => [
                'user',
                'message',
                'uuid',
                'token_type',
                'access_token'
            ],
            'code'
        ]);

        $response->assertJsonPath('data.message', trans('api_v1.verification_code.verification_code_sent_successfully'));
        $response->assertJsonPath('data.user.id', $user->id);
        $this->assertNotNull($response->json('data.uuid'));
        $response->assertJsonPath('data.token_type', 'Bearer');
    }

}
