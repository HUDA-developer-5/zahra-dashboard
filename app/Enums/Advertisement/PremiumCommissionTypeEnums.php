<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum PremiumCommissionTypeEnums: string implements IEnum
{
    case Fixed = 'fixed';
    case Percentage = 'percentage';

    public static function asArray(): array
    {
        return [
            self::Fixed->value => self::Fixed->name,
            self::Percentage->value => self::Percentage->name,
        ];
    }
}
