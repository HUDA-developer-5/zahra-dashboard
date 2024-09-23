<?php

namespace App\Services\User;

use App\DTOs\User\CreateWalletTransactionDTO;
use App\DTOs\User\PaymentTransactionDTO;
use App\DTOs\User\ReturnPaymentTransactionDTO;
use App\Enums\User\PaymentMethodsEnum;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Enums\User\PaymentTransactionTypesEnum;
use App\Enums\User\WalletTransactionTypesEnum;
use App\Helpers\GlobalHelper;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentService
{
    public function chargeWallet(User $user, $amount, $paymentMethod, $currency): ReturnPaymentTransactionDTO
    {
        // create payment transaction
        $paymentTransactionDTO = PaymentTransactionDTO::from([
            'payment_method' => PaymentMethodsEnum::Stripe,
            'type' => PaymentTransactionTypesEnum::RechargeWallet,
            'status' => PaymentTransactionStatusEnum::Pending,
            'amount' => GlobalHelper::getNumberFormat($amount),
            'currency' => $currency,
            'user_id' => $user->id,
            'description' => 'Recharge Wallet with ' . $amount . ' ' . $currency . ' using ' . $paymentMethod,
        ]);

        $paymentTransaction = $this->createPaymentTransaction($paymentTransactionDTO);
        // deduct this amount from user strip account using the payment method
        $returnPaymentTransactionDTO = $this->charge($user, $paymentMethod, $paymentTransaction);
        $this->updatePaymentTransactionAfterPayment($paymentTransaction, $returnPaymentTransactionDTO->status, [$returnPaymentTransactionDTO->message]);

        // if the payment is successful, update user wallet balance
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $walletTransactionService = new WalletTransactionService();
            $user = $walletTransactionService->addWalletBalance($user, $amount,$currency);

            $user_balance = $currency == 'SAR' ? $user->balance_sar : ($currency == 'EGP' ? $user->balance_egp : $user->balance_aed);

            // add wallet transaction
            $walletTransactionService->createWalletTransaction(CreateWalletTransactionDTO::from([
                'user_id' => $user->id,
                'current_balance' => $user_balance,
                'amount' => $amount,
                'previous_balance' => $user_balance - $amount,
                'type' => WalletTransactionTypesEnum::Add,
                'payment_transaction_id' => $paymentTransaction->id,
                'currency' => $currency
            ]));
        }
        return $returnPaymentTransactionDTO;
    }

    public function payCommission(User $user, $amount, $paymentMethod, $currency): ReturnPaymentTransactionDTO
    {
        // create payment transaction
        $paymentTransactionDTO = PaymentTransactionDTO::from([
            'payment_method' => PaymentMethodsEnum::Stripe,
            'type' => PaymentTransactionTypesEnum::PayCommission,
            'status' => PaymentTransactionStatusEnum::Pending,
            'amount' => GlobalHelper::getNumberFormat($amount),
            'currency' => $currency,
            'user_id' => $user->id,
            'description' => 'Pay Commission amount: ' . $amount . ' ' . $currency . ' using ' . $paymentMethod,
        ]);

        $paymentTransaction = $this->createPaymentTransaction($paymentTransactionDTO);
        // deduct this amount from user strip account using the payment method
        $returnPaymentTransactionDTO = $this->charge($user, $paymentMethod, $paymentTransaction);
        $this->updatePaymentTransactionAfterPayment($paymentTransaction, $returnPaymentTransactionDTO->status, [$returnPaymentTransactionDTO->message]);
        return $returnPaymentTransactionDTO;
    }

    public function payPremiumSubscription(User $user, $amount, $paymentMethod, $currency): ReturnPaymentTransactionDTO
    {
        // create payment transaction
        $paymentTransactionDTO = PaymentTransactionDTO::from([
            'payment_method' => PaymentMethodsEnum::Stripe,
            'type' => PaymentTransactionTypesEnum::PayPremiumSubscription,
            'status' => PaymentTransactionStatusEnum::Pending,
            'amount' => GlobalHelper::getNumberFormat($amount),
            'currency' => $currency,
            'user_id' => $user->id,
            'description' => 'Pay Premium Subscription amount: ' . $amount . ' ' . $currency . ' using ' . $paymentMethod,
        ]);

        $paymentTransaction = $this->createPaymentTransaction($paymentTransactionDTO);
        // deduct this amount from user strip account using the payment method
        $returnPaymentTransactionDTO = $this->charge($user, $paymentMethod, $paymentTransaction);
        $this->updatePaymentTransactionAfterPayment($paymentTransaction, $returnPaymentTransactionDTO->status, [$returnPaymentTransactionDTO->message]);
        return $returnPaymentTransactionDTO;
    }

    public function payPremiumAdvertisementAdjustment(User $user, $amount, $paymentMethod, $currency): ReturnPaymentTransactionDTO
    {
        // create payment transaction
        $paymentTransactionDTO = PaymentTransactionDTO::from([
            'payment_method' => PaymentMethodsEnum::Stripe,
            'type' => PaymentTransactionTypesEnum::PayPremiumAdvertisement,
            'status' => PaymentTransactionStatusEnum::Pending,
            'amount' => GlobalHelper::getNumberFormat($amount),
            'currency' => $currency,
            'user_id' => $user->id,
            'description' => 'Pay Premium Advertisement amount: ' . $amount . ' ' . $currency . ' using ' . $paymentMethod,
        ]);

        $paymentTransaction = $this->createPaymentTransaction($paymentTransactionDTO);
        // deduct this amount from user strip account using the payment method
        $returnPaymentTransactionDTO = $this->charge($user, $paymentMethod, $paymentTransaction);
        $this->updatePaymentTransactionAfterPayment($paymentTransaction, $returnPaymentTransactionDTO->status, [$returnPaymentTransactionDTO->message]);
        return $returnPaymentTransactionDTO;
    }

    public function charge(User $user, $paymentMethodId, PaymentTransaction $paymentTransaction): ReturnPaymentTransactionDTO
    {
        try {
            // Charge the user using the specified payment method ID and currency
            $amount = GlobalHelper::convertToSmallestDenomination($paymentTransaction->amount);
            $user->charge($amount, $paymentMethodId, [
                'confirmation_method' => 'automatic',
                'confirm' => true,
                'currency' => $paymentTransaction->currency,
                'return_url' => route('payment.webhook', ['provider' => $paymentTransaction->payment_method]),
                'metadata' => [
                    'invoice_number' => $paymentTransaction->transaction_number,
                ],
            ]);
            return ReturnPaymentTransactionDTO::from([
                'status' => PaymentTransactionStatusEnum::Completed,
                'message' => 'Payment completed successfully',
                'payment_transaction_id' => $paymentTransaction->id
            ]);
        } catch (\Exception $e) {
            return ReturnPaymentTransactionDTO::from([
                'status' => PaymentTransactionStatusEnum::Failed,
                'message' => $e->getMessage(),
                'payment_transaction_id' => $paymentTransaction->id
            ]);
        }
    }

    public function createPaymentTransaction(PaymentTransactionDTO $paymentTransactionDTO): PaymentTransaction
    {
        $paymentTransaction = new PaymentTransaction();
        $paymentTransaction->user_id = $paymentTransactionDTO->user_id;
        $paymentTransaction->payment_method = $paymentTransactionDTO->payment_method->value;
        $paymentTransaction->type = $paymentTransactionDTO->type->value;
        $paymentTransaction->amount = $paymentTransactionDTO->amount;
        $paymentTransaction->currency = $paymentTransactionDTO->currency;
        $paymentTransaction->status = $paymentTransactionDTO->status->value;
        $paymentTransaction->transaction_number = Str::uuid()->toString();
        $paymentTransaction->description = $paymentTransactionDTO->description;
        $paymentTransaction->save();

        return $paymentTransaction;
    }

    public function updatePaymentTransactionAfterPayment(PaymentTransaction $paymentTransaction, PaymentTransactionStatusEnum $status, array $response = []): PaymentTransaction
    {
        $paymentTransaction->status = $status->value;
        $paymentTransaction->response = $response;
        $paymentTransaction->save();
        return $paymentTransaction->refresh();
    }
}
