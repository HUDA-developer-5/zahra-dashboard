<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum UserStatusEnums: string implements IEnum
{
    case Active = 'Active';
    case Pending = 'Pending';
    case Blocked = 'Blocked';

    public static function asArray(): array
    {
        return [
            self::Active->value => self::Active->name,
            self::Pending->value => self::Pending->name,
            self::Blocked->value => self::Blocked->name,
        ];
    }
}
