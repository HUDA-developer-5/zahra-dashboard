<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum PaymentMethodsEnum: string implements IEnum
{
    case Stripe = 'stripe';

    case Wallet = 'wallet';

    public static function asArray(): array
    {
        return [
            self::Stripe->value => self::Stripe->name,
            self::Wallet->value => self::Wallet->name,
        ];
    }
}
