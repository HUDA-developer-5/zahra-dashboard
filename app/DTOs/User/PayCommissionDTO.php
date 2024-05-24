<?php

namespace App\DTOs\User;

use App\Enums\CommissionPayWithTypesEnums;
use Spatie\LaravelData\Data;

class PayCommissionDTO extends Data
{
    public string $commission_id;

    public CommissionPayWithTypesEnums $payment_type;
}