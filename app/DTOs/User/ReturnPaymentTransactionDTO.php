<?php

namespace App\DTOs\User;

use App\Enums\User\PaymentTransactionStatusEnum;
use Spatie\LaravelData\Data;

class ReturnPaymentTransactionDTO extends Data
{
    public PaymentTransactionStatusEnum $status;

    public string $message;

    public ?int $payment_transaction_id;
}