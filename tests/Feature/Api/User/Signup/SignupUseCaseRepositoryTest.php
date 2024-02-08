<?php

namespace Tests\Feature\Api\User\Signup;

use App\DTOs\User\Signup\CreateUserDTO;
use App\Enums\Verification\ScreeningRequestProviderEnum;
use App\Enums\Verification\ScreeningRequestStatusEnum;
use App\Enums\Verification\ScreeningRequestTypesEnum;
use App\Models\User;
use App\Repositories\Api\V1\User\Auth\UseCases\SignupUseCaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SignupUseCaseRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // setup method
    protected function setUp(): void
    {
        parent::setUp();
        // call passport install command
        Artisan::call('passport:install --force');
    }

    // test execute method in SignupUseCaseRepository class with invalid data
    public function test_execute_method_in_SignupUseCaseRepository_class_with_invalid_data()
    {
        $this->expectExceptionMessage('Typed property App\DTOs\User\Signup\CreateUserDTO::$national_id must not be accessed before initialization');
        (new SignupUseCaseRepository())->execute(new CreateUserDTO());
    }

    // test execute method in SignupUseCaseRepository class with valid data
    public function test_execute_method_in_SignupUseCaseRepository_class_with_valid_data()
    {
        $createUserDTO = $this->getCreateUserDTO();
        $returnSignupUseCaseDTO = (new SignupUseCaseRepository())->execute($createUserDTO);

        // return SignupUseCaseDTO
        $this->assertNotNull($returnSignupUseCaseDTO);
        $this->assertNotNull($returnSignupUseCaseDTO->user);
        $this->assertNotNull($returnSignupUseCaseDTO->access_token);

        // assert user
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'id' => $returnSignupUseCaseDTO->user->id,
            'email' => $createUserDTO->email,
            'national_id' => $createUserDTO->national_id,
            'phone_number' => $createUserDTO->phone_number
        ]);

        // assert screening request
        $this->assertDatabaseCount('screening_requests', 1);
        $this->assertDatabaseHas('screening_requests', [
            'national_id' => $createUserDTO->national_id,
            'provider' => ScreeningRequestProviderEnum::FOCAL->value,
            'status' => ScreeningRequestStatusEnum::PENDING->value,
            'type' => ScreeningRequestTypesEnum::YAKEEN_OTP->value,
        ]);
    }

    // test execute method in SignupUseCaseRepository class with valid data and user already exists
    public function test_execute_method_in_SignupUseCaseRepository_class_with_valid_data_and_user_already_exists()
    {
        $createUserDTO = $this->getCreateUserDTO();
        $user = User::factory()->create($createUserDTO->toArray());

        // assert user
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $createUserDTO->email,
            'national_id' => $createUserDTO->national_id,
            'phone_number' => $createUserDTO->phone_number
        ]);

        // assert screening request
        $this->assertDatabaseCount('screening_requests', 0);

        // Attempt to create a user with the same email
        try {
            $returnSignupUseCaseDTO = (new SignupUseCaseRepository())->execute($createUserDTO);
        } catch (QueryException $e) {
            // Check if the exception is a UniqueConstraintViolationException
            $this->assertEquals('23000', $e->getCode()); // 23000 is the SQL error code for a unique constraint violation
            return;
        }

        // If we didn't catch the exception, the test should fail
        $this->fail('Expected UniqueConstraintViolationException was not thrown.');
    }

    protected function getCreateUserDTO() : CreateUserDTO
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
