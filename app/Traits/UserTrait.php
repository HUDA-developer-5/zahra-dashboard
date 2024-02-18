<?php

namespace App\Traits;

use App\DTOs\User\AccessTokenDTO;
use App\Enums\User\LanguageKeysEnum;
use App\Enums\User\UserStatusEnums;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait UserTrait
{
    // create temporary user token
    public function createAccessToken(User $user, string $name = 'api'): AccessTokenDTO
    {
        // Create an access token with a custom expiration time
        $token = $user->createToken($name);
        // Get the access token
        return AccessTokenDTO::from([
            'accessToken' => $token->accessToken,
            'accessTokenExpirationTime' => $token->token->expires_at,
            'tokenType' => 'Bearer'
        ]);
    }

    // revoke user tokens
    public function revokeTokens(User $user): void
    {
        $user->tokens()->update([
            'revoked' => true
        ]);
    }

    public function updateUserStatus(UserStatusEnums $userStatusEnum, User $user): User
    {
        $user->status = $userStatusEnum->value;
        $user->save();
        return $user;
    }

    // check if user can login based on user status
    public function canLogin(User $user): bool
    {
        return $user->status == UserStatusEnums::Active->value;
    }

    // check if user password is correct
    public function isPasswordMatch(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    // get Access token from authed user
    public function getAccessTokenForAuthedUser(): AccessTokenDTO
    {
        $user = Auth::user();
        // Access the access token details
        $accessToken = $user->token();
        return AccessTokenDTO::from([
            'accessToken' => request()->bearerToken(),
            'accessTokenExpirationTime' => $accessToken->expires_at,
            'tokenType' => 'Bearer',
        ]);
    }

    public function haveBalance($balance_needed)
    {
        return $this->balance >= $balance_needed;
    }

    public function updateDefaultLanguage(User $user, LanguageKeysEnum $language): void
    {
        $user->update(['default_language' => $language->value]);
    }
}
