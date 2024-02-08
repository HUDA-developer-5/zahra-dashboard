<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum AdminTypesEnums: string implements IEnum
{
    case Admin = 'Admin';
    case Teacher = 'Teacher';

    public static function asArray(): array
    {
        return [
            self::Admin->value => self::Admin->name,
            self::Teacher->value => self::Teacher->name,
        ];
    }
}
