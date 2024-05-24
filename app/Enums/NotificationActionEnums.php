<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum NotificationActionEnums: string implements IEnum
{
    case FollowComment = 'FollowComment';
    case NotifyAdsOwnerWithNewComment = 'NotifyAdsOwnerWithNewComment';
    case NotifyAdsOwnerWithPurchased = 'NotifyAdsOwnerWithPurchased';
    case NotifyAdsOwnerWithOpenOffer = 'NotifyAdsOwnerWithOpenOffer';

    public static function asArray(): array
    {
        return [
            self::FollowComment->value => self::FollowComment->name,
            self::NotifyAdsOwnerWithNewComment->value => self::NotifyAdsOwnerWithNewComment->name,
            self::NotifyAdsOwnerWithPurchased->value => self::NotifyAdsOwnerWithPurchased->name,
            self::NotifyAdsOwnerWithOpenOffer->value => self::NotifyAdsOwnerWithOpenOffer->name,
        ];
    }
}
