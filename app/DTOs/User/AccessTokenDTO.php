<?php

namespace App\DTOs\User;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class AccessTokenDTO extends Data
{
    public string $accessToken;

    public Carbon $accessTokenExpirationTime;

    public string $tokenType;
}