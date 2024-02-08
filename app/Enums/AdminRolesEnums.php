<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum AdminRolesEnums: string implements IEnum
{
    case Super_Admin = 'Super_Admin';
    case Editor = 'Editor';

    public static function asArray(): array
    {
        return [
            self::Super_Admin->value => self::Super_Admin->name,
            self::Editor->value => self::Editor->name,
        ];
    }
}
