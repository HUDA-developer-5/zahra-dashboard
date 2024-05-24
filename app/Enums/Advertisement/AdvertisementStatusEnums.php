<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum AdvertisementStatusEnums: string implements IEnum
{
    case Pending = 'pending';
    case Active = 'active';
    case Deactivated = 'deactivated';

    public static function asArray(): array
    {
        return [
            self::Pending->value => self::Pending->name,
            self::Active->value => self::Active->name,
            self::Deactivated->value => self::Deactivated->name,
        ];
    }
}
