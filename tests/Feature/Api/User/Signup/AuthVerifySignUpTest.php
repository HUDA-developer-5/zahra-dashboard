<?php

namespace Tests\Feature\Api\User\Signup;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthVerifySignUpTest extends TestCase
{
    use RefreshDatabase;

    // test api validate signup already exists
    public function test_api_validate_signup_already_exists()
    {
        $response = $this->postJson('/api/v1/user/signup/validate', $this->userData());
        $response->assertStatus(200);
    }

    // test api validate method not allowed
    public function test_api_validate_method_not_allowed()
    {
        $response = $this->getJson('/api/v1/user/signup/validate');
        $response->assertStatus(405);
        $response->assertMethodNotAllowed();
    }

    // test api validate signup validation error
    public function test_api_validate_signup_validation_error()
    {
        $response = $this->postJson('/api/v1/user/signup/validate');

        $response->assertJsonValidationErrors([
            'email',
            'national_id',
            'phone_number',
            'date_of_birth'
        ]);
        // assert json structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'national_id',
                'phone_number',
                'date_of_birth'
            ]
        ]);
        $response->assertStatus(422);
    }

    private function userData(): array
    {
        return [
            'email' => 'ayman@mail.com',
            'national_id' => '123456789',
            'phone_number' => '+966582014422',
            'date_of_birth' => '1992-4-24'
        ];
    }
}
