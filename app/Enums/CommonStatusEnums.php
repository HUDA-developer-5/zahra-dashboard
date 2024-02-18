<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum CommonStatusEnums: string implements IEnum
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
