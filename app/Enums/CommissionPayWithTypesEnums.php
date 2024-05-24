<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum CommissionPayWithTypesEnums: string implements IEnum
{
    case Wallet = 'wallet';
    case Card = 'card';

    public static function asArray(): array
    {
        return [
            self::Wallet->value => self::Wallet->name,
            self::Card->value => self::Card->name,
        ];
    }
}
