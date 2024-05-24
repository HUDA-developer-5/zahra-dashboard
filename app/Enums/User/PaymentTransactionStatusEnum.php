<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum PaymentTransactionStatusEnum: string implements IEnum
{
    case Pending = 'pending';

    case Completed = 'completed';

    case Canceled = 'canceled';

    case Failed = 'failed';


    public static function asArray(): array
    {
        return [
            self::Pending->value => self::Pending->name,
            self::Completed->value => self::Completed->name,
            self::Canceled->value => self::Canceled->name,
            self::Failed->value => self::Failed->name,
        ];
    }
}
