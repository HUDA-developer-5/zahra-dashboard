<?php

namespace App\Enums\User;

use App\Contracts\IEnum;

enum PaymentTransactionTypesEnum: string implements IEnum
{
    case PayCommission = 'pay_commission';

    case RechargeWallet = 'recharge_wallet';

    case PayPremiumSubscription = 'pay_premium_subscription';

    case PayPremiumAdvertisement = 'pay_premium_advertisement';

    public static function asArray(): array
    {
        return [
            self::PayCommission->value => self::PayCommission->name,
            self::RechargeWallet->value => self::RechargeWallet->name,
            self::PayPremiumSubscription->value => self::PayPremiumSubscription->name,
            self::PayPremiumAdvertisement->value => self::PayPremiumAdvertisement->name
        ];
    }
}
