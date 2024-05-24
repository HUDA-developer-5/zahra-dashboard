<?php

namespace App\DTOs\User;

use Spatie\LaravelData\Data;

class StoreContactusDTO extends Data
{
    public ?string $title;

    public string $name;

    public ?string $email;

    public string $phone_number;

    public string $message;
}