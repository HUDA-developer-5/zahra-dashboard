<?php

namespace App\DTOs\User;

use Spatie\LaravelData\Data;

class UserRegisterDTO extends Data
{
    public string $name;

    public string $email;

    public ?string $phone_number;

    public ?string $password;
}