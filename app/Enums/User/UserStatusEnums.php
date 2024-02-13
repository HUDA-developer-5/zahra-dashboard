<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum UserStatusEnums: string implements IEnum
{
    case Active = 'Active';
    case Deactivated = 'Deactivated';

    public static function asArray(): array
    {
        return [
            self::Active->value => self::Active->name,
            self::Deactivated->value => self::Deactivated->name,
        ];
    }
}
