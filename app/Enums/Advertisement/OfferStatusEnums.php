<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum OfferStatusEnums: string implements IEnum
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public static function asArray(): array
    {
        return [
            self::Pending->value => self::Pending->name,
            self::Approved->value => self::Approved->name,
            self::Rejected->value => self::Rejected->name,
        ];
    }
}
