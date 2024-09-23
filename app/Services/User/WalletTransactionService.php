<?php

namespace App\Services\User;

use App\DTOs\User\CreateWalletTransactionDTO;
use App\Models\User;
use App\Models\WalletTransaction;

class WalletTransactionService
{
    public function deductWalletBalance(User $user, $amount): User
    {
        $user->balance = $user->balance - $amount;
        $user->save();
        return $user;
    }

    public function addWalletBalance(User $user, $amount, $currency): User
    {
        if ($currency == 'SAR') {
            $user->balance_sar = $user->balance_sar + $amount;
        } elseif ($currency == 'EGP') {
            $user->balance_egp = $user->balance_egp + $amount;
        } else{
            $user->balance_aed = $user->balance_aed + $amount;
        }

//        $user->balance = $user->balance + $amount;

        $user->save();
        return $user;
    }

    // create wallet transaction for user
    public function createWalletTransaction(CreateWalletTransactionDTO $createWalletTransactionDTO): void
    {
        $walletTransaction = new WalletTransaction();
        $walletTransaction->user_id = $createWalletTransactionDTO->user_id;
        $walletTransaction->wallet_id = $createWalletTransactionDTO->user_id;
        $walletTransaction->current_balance = $createWalletTransactionDTO->current_balance;
        $walletTransaction->previous_balance = $createWalletTransactionDTO->previous_balance;
        $walletTransaction->amount = $createWalletTransactionDTO->amount;
        $walletTransaction->type = $createWalletTransactionDTO->type->value;
        $walletTransaction->payment_transaction_id = $createWalletTransactionDTO->payment_transaction_id;
        $walletTransaction->currency = $createWalletTransactionDTO->currency;
        $walletTransaction->save();
    }
}
