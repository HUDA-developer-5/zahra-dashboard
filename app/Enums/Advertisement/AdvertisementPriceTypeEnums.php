<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum AdvertisementPriceTypeEnums: string implements IEnum
{
    case Fixed = 'fixed';
    case OpenOffer = 'open_offer';

    public static function asArray(): array
    {
        return [
            self::Fixed->value => self::Fixed->name,
            self::OpenOffer->value => self::OpenOffer->name,
        ];
    }
}
