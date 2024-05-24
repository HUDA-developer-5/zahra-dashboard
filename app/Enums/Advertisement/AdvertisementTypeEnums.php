<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum AdvertisementTypeEnums: string implements IEnum
{
    case Free = 'free';
    case Premium = 'premium';

    public static function asArray(): array
    {
        return [
            self::Free->value => self::Free->name,
            self::Premium->value => self::Premium->name,
        ];
    }
}
