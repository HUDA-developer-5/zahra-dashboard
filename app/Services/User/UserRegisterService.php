<?php

namespace App\Services\User;

use App\DTOs\User\UserRegisterDTO;
use App\Enums\User\UserStatusEnums;
use App\Models\User;

class UserRegisterService
{
    public function store(UserRegisterDTO $userRegisterDTO): User
    {
        $user = new User();
        $user->name = $userRegisterDTO->name;
        $user->email = $userRegisterDTO->email;
        $user->phone_number = ($userRegisterDTO->phone_number) ?: null;
        $user->password = ($userRegisterDTO->password) ? bcrypt($userRegisterDTO->password) : null;
        $user->status = UserStatusEnums::Active->name;
        $user->save();
        return $user;
    }
}