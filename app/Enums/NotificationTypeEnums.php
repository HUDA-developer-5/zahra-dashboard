<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum NotificationTypeEnums: string implements IEnum
{
    case Push = 'push';
    case Sms = 'sms';
    case Email = 'email';

    public static function asArray(): array
    {
        return [
            self::Push->value => self::Push->name,
            self::Sms->value => self::Sms->name,
            self::Email->value => self::Email->name,
        ];
    }
}
