<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum AdminTypesEnums: string implements IEnum
{
    case Admin = 'Admin';

    public static function asArray(): array
    {
        return [
            self::Admin->value => self::Admin->name,
        ];
    }
}
