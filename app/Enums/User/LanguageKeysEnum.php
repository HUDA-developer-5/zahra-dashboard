<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum LanguageKeysEnum: string implements IEnum
{
    case EN = 'en';

    case AR = 'ar';

    public static function asArray(): array
    {
        return [
            self::EN->value => 'en',
            self::AR->value => 'ar',
        ];
    }
}
