<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum ChatTypeEnums: int implements IEnum
{
    case USER_TO_USER = 1;
    case USER_TO_ADMIN = 2;

    public static function asArray(): array
    {
        return [
            self::USER_TO_USER->value => self::USER_TO_USER->name,
            self::USER_TO_ADMIN->value => self::USER_TO_ADMIN->name
        ];
    }
}
