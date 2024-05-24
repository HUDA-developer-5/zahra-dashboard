<?php

namespace App\Enums;

use App\Contracts\IEnum;

enum StaticPagesEnums: string implements IEnum
{
    case AboutUs = 'about-us';
    case HowToBePremium = 'how-to-be-premium';
    case PrivacyPolicy = 'privacy-policy';
    case TermsAndConditions = 'terms-and-conditions';
    case SellingAndDealingInstructions = 'selling-and-dealing-instructions';
    case SpecialAdvertisement = 'special-advertisement';
    case PaymentFees = 'payment-fees';
    case SafetyCenter = 'safety-center';
    case UsageAgreement = 'usage-agreement';
    case ProhibitedAdvertisements = 'prohibited-advertisements';

    public static function asArray(): array
    {
        return [
            self::AboutUs->value => self::AboutUs->name,
            self::HowToBePremium->value => self::HowToBePremium->name,
            self::PrivacyPolicy->value => self::PrivacyPolicy->name,
            self::TermsAndConditions->value => self::TermsAndConditions->name,
            self::SellingAndDealingInstructions->value => self::SellingAndDealingInstructions->name,
            self::SpecialAdvertisement->value => self::SpecialAdvertisement->name,
            self::PaymentFees->value => self::PaymentFees->name,
            self::SafetyCenter->value => self::SafetyCenter->name,
            self::UsageAgreement->value => self::UsageAgreement->name,
            self::ProhibitedAdvertisements->value => self::ProhibitedAdvertisements->name,
        ];
    }
}
