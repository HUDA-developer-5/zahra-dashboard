<?php

namespace App\Services\User;

use App\Models\User;

class UserLoginService
{
    public function login(string $userName, string $password): ?User
    {
        $userService = new UserService();

        $user = $userService->findByPhoneNumber($userName);

        if (!$user) {
            $user = $userService->findByEmail($userName);
        }

        // check if password matched
        if ($user && $user->canLogin($user) && $user->isPasswordMatch($user, $password)) {
            return $user;
        }
        return null;
    }
}