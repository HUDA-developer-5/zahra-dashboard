<?php

namespace App\DTOs\Advertisement;

use Spatie\LaravelData\Data;

class AdvertisementCommissionDetailsDTO extends Data
{
    public float $commission;

    public float $amount_after_commission;

    public float $amount;

    public int $days;
}