<?php

namespace App\Services\User;

use App\Enums\User\LanguageKeysEnum;
use App\Models\User;

class UserService
{
    public function updateDefaultLanguage(User $user, LanguageKeysEnum $language): void
    {
        $user->update(['default_language' => $language->value]);
    }

    public function findByPhoneNumber(string $phoneNumber): ?User
    {
        return User::where('phone_number', '=', $phoneNumber)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', '=', $email)->first();
    }

    public function logout(User $user): void
    {
        $user->revokeTokens($user);
    }

    public function updatePassword(User $user, string $password): User
    {
        $user->update([
            'password' => bcrypt($password)
        ]);
        return $user;
    }
}