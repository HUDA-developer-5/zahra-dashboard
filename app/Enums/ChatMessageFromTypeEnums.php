<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum ChatMessageFromTypeEnums: int implements IEnum
{
    case FROM_USER = 1;
    case FROM_ADMIN = 2;

    public static function asArray(): array
    {
        return [
            self::FROM_USER->value => self::FROM_USER->name,
            self::FROM_ADMIN->value => self::FROM_ADMIN->name
        ];
    }
}
