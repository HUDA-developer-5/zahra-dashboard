<?php

namespace Tests\Feature\Api\User\Signup;

use App\DTOs\User\Signup\CreateUserDTO;
use App\DTOs\User\Signup\ReturnSignupUseCaseDTO;
use App\Enums\User\UserProfileStatusEnum;
use App\Repositories\Api\V1\User\Auth\UseCases\SignupUseCaseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class VerifyAccountAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install --force');
    }

    // test api verify account already exists
    public function test_api_verify_account_validation_errors()
    {
        $returnSignupUseCaseDTO = $this->createUser();
        $response = $this->actingAs($returnSignupUseCaseDTO->user)
            ->postJson('/api/v1/user/signup/verify');
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['code']);

        // assert json structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'code',
            ]
        ]);
    }

    public function test_api_verify_account_with_valida_data()
    {
        $returnSignupUseCaseDTO = $this->createUser();
        $response = $this->actingAs($returnSignupUseCaseDTO->user)
            ->postJson('/api/v1/user/signup/verify', ['code' => "142536"]);
        $response->assertStatus(200);
        // assert json structure
        $response->assertJsonStructure([
            'data' => [
                'user',
                'user_profile_status',
                'message',
                'token_type',
                'access_token'
            ],
            'code'
        ]);

        $response->assertJsonPath('data.user_profile_status', UserProfileStatusEnum::ENTER_VALID_DATA->value);
    }

    protected function createUser(): ReturnSignupUseCaseDTO
    {
        return (new SignupUseCaseRepository())->execute($this->getCreateUserDTO());
    }

    protected function getCreateUserDTO(): CreateUserDTO
    {
        $createUserDTO = new CreateUserDTO();
        $createUserDTO->national_id = $this->faker->randomNumber(9);
        $createUserDTO->phone_number = $this->faker->phoneNumber;
        $createUserDTO->email = $this->faker->safeEmail();
        $createUserDTO->date_of_birth = $this->faker->date();
        $createUserDTO->password = $this->faker->password(8);
        return $createUserDTO;
    }
}
