<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum WalletTransactionTypesEnum: string implements IEnum
{
    case Add = 'add';

    case Deduct = 'deduct';

    public static function asArray(): array
    {
        return [
            self::Add->value => 'Add',
            self::Deduct->value => 'Deduct',
        ];
    }
}
