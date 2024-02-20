<?php

namespace App\DTOs\User;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class UpdateUserProfileDTO extends Data
{
    public ?string $name;

    public ?string $phone_number;

    public ?string $email;

    public ?int $nationality_id;

    public ?UploadedFile $image;
}