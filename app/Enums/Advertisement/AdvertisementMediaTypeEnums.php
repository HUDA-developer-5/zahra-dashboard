<?php

namespace App\Enums\Advertisement;

use App\Contracts\IEnum;

enum AdvertisementMediaTypeEnums: string implements IEnum
{
    case Video = 'video';
    case Image = 'image';

    public static function asArray(): array
    {
        return [
            self::Video->value => self::Video->name,
            self::Image->value => self::Image->name,
        ];
    }
}
