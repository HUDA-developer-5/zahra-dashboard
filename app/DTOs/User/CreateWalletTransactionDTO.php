<?php

namespace App\DTOs\User;

use App\Enums\User\WalletTransactionTypesEnum;
use Spatie\LaravelData\Data;

class CreateWalletTransactionDTO extends Data
{
    public WalletTransactionTypesEnum $type;

    public int $user_id;

    public float $current_balance;

    public float $previous_balance;

    public float $amount;

    public string $payment_transaction_id;

    public string $currency;

}
