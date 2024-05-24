<?php

namespace App\DTOs\User;

use App\Enums\User\PaymentMethodsEnum;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Enums\User\PaymentTransactionTypesEnum;
use Spatie\LaravelData\Data;

class PaymentTransactionDTO extends Data
{
    public PaymentMethodsEnum $payment_method;

    public PaymentTransactionStatusEnum $status;

    public int $user_id;

    public string $payment_method_id;

    public float $amount;

    public string $currency;

    public PaymentTransactionTypesEnum $type;

    public ?string $description;
}