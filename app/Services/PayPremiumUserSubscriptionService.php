<?php

namespace App\Services;

use App\DTOs\User\CreateWalletTransactionDTO;
use App\DTOs\User\PaymentTransactionDTO;
use App\Enums\CommissionPayWithTypesEnums;
use App\Enums\User\PaymentMethodsEnum;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Enums\User\PaymentTransactionTypesEnum;
use App\Enums\User\WalletTransactionTypesEnum;
use App\Models\PremiumUserSetting;
use App\Models\PremiumUserSubscription;
use App\Models\User;
use App\Services\User\PaymentService;
use App\Services\User\WalletTransactionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PayPremiumUserSubscriptionService
{
    public function paySubscription(User $user, CommissionPayWithTypesEnums $commissionPayWithTypesEnums): RedirectResponse
    {
        if ($this->checkIfUserHasActiveSubscription($user)) {
            toastr()->warning(trans('api.already subscribed'));
            return redirect()->route('web.premium.show');
        }
        // check commission id (all or id) and related to logged-in user
        if ($commissionPayWithTypesEnums->value == CommissionPayWithTypesEnums::Card->value) {
            return redirect()->route('web.premium.payWithCard');
        }

        $premiumUserSetting = (new DynamicPageService())->getPremiumSetting();
        if (!$premiumUserSetting || $premiumUserSetting->price == 0) {
            toastr()->warning(trans('api.no premium subscription found'));
            return redirect()->route('web.premium.show');
        }

        $response = $this->payByWallet($user, $premiumUserSetting);
        if ($response['status']->value == PaymentTransactionStatusEnum::Completed->value) {
            toastr()->success(trans('api.paid successfully'));
        } else {
            toastr()->warning(trans('api.not enough balance'));
        }
        return redirect()->route('web.premium.show');
    }

    public function mobilePayByWallet(User $user): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        if ($this->checkIfUserHasActiveSubscription($user)) {
            return [
                'message' => trans('api.already subscribed'),
                'status' => $status
            ];
        }

        $premiumUserSetting = (new DynamicPageService())->getPremiumSetting();
        if (!$premiumUserSetting || $premiumUserSetting->price == 0) {
            return [
                'message' => trans('api.no premium subscription found'),
                'status' => $status
            ];
        }

        $response = $this->payByWallet($user, $premiumUserSetting);
        if ($response['status']->value == PaymentTransactionStatusEnum::Completed->value) {
            $message = trans('api.paid successfully');
            $status = PaymentTransactionStatusEnum::Completed;
        } else {
            $message = trans('api.not enough balance');
        }
        return [
            'message' => $message,
            'status' => $status
        ];
    }

    public function mobilePayByCard(User $user, $paymentMethod): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        if ($this->checkIfUserHasActiveSubscription($user)) {
            return [
                'message' => trans('api.already subscribed'),
                'status' => $status
            ];
        }

        $premiumUserSetting = (new DynamicPageService())->getPremiumSetting();
        if (!$premiumUserSetting || $premiumUserSetting->price == 0) {
            return [
                'message' => trans('api.no premium subscription found'),
                'status' => $status
            ];
        }

        $currency = $user->default_currency;
        $returnPaymentTransactionDTO = (new PaymentService())->payPremiumSubscription($user, $premiumUserSetting->price, $paymentMethod, $currency);
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $message = trans('api.paid successfully');
            $status = PaymentTransactionStatusEnum::Completed;
        } else {
            $message = trans('api.PaymentFailed');
        }
        return [
            'message' => $message,
            'status' => $status
        ];
    }

    public function payByWallet(User $user, PremiumUserSetting $premiumUserSetting): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $transactionId = null;
        // check the wallet amount
        $walletBalance = $user->balance;
        $totalAmount = $premiumUserSetting->price;
        if ($walletBalance < $totalAmount) {
            return [
                'status' => $status,
                'transactionId' => $transactionId
            ];
        }

        try {
            DB::beginTransaction();
            $currency = $user->default_currency;
            // add new payment transaction with wallet type
            $paymentTransactionDTO = PaymentTransactionDTO::from([
                'payment_method' => PaymentMethodsEnum::Wallet,
                'type' => PaymentTransactionTypesEnum::PayPremiumSubscription,
                'status' => PaymentTransactionStatusEnum::Completed,
                'amount' => $totalAmount,
                'currency' => $currency,
                'user_id' => $user->id,
                'description' => 'Pay Premium Subscription from Wallet with ' . $totalAmount . ' ' . $currency . ' using ' . PaymentMethodsEnum::Wallet->value,
            ]);

            $paymentTransaction = (new PaymentService())->createPaymentTransaction($paymentTransactionDTO);
            // add new wallet transaction with deduct type
            $walletTransactionService = new WalletTransactionService();
            // deduct this amount from balance
            $user = $walletTransactionService->deductWalletBalance($user, $totalAmount);
            // add wallet transaction
            $walletTransactionService->createWalletTransaction(CreateWalletTransactionDTO::from([
                'user_id' => $user->id,
                'current_balance' => $user->balance,
                'amount' => $totalAmount,
                'previous_balance' => $user->balance - $totalAmount,
                'type' => WalletTransactionTypesEnum::Deduct,
                'payment_transaction_id' => $paymentTransaction->id
            ]));
            // create new subscription
            $this->createPremiumUserSubscription($user, $premiumUserSetting, $paymentTransaction->id);
            DB::commit();
            return [
                'status' => PaymentTransactionStatusEnum::Completed,
                'transactionId' => $paymentTransaction->id
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => $status,
                'transactionId' => $transactionId
            ];
        }
    }

    public function payByCard(User $user, $paymentMethod)
    {
        if ($this->checkIfUserHasActiveSubscription($user)) {
            toastr()->warning(trans('api.already subscribed'));
            return redirect()->route('web.premium.show');
        }

        $premiumUserSetting = (new DynamicPageService())->getPremiumSetting();
        if (!$premiumUserSetting || $premiumUserSetting->price == 0) {
            toastr()->warning(trans('api.no premium subscription found'));
            return redirect()->route('web.premium.show');
        }

        $currency = $user->default_currency;
        $returnPaymentTransactionDTO = (new PaymentService())->payPremiumSubscription($user, $premiumUserSetting->price, $paymentMethod, $currency);
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $this->createPremiumUserSubscription($user, $premiumUserSetting, $returnPaymentTransactionDTO->payment_transaction_id);
            toastr()->success(trans('api.paid successfully'));
        } else {
            toastr()->warning(trans('api.PaymentFailed'));
        }
        return redirect()->route('web.premium.show');
    }

    public function createPremiumUserSubscription(User $user, PremiumUserSetting $premiumUserSetting, $transactionId): PremiumUserSubscription
    {
        if ($user->premiumSubscription) {
            $model = $user->premiumSubscription;
        } else {
            $model = new PremiumUserSubscription();
        }
        $model->user_id = $user->id;
        $model->premium_ads_percentage = $premiumUserSetting->premium_ads_percentage;
        $model->premium_ads_count = $premiumUserSetting->premium_ads_count;
        $model->start_date = Carbon::now();
        $model->end_date = Carbon::now()->addMonths($premiumUserSetting->duration_in_months);
        $model->transaction_id = $transactionId;
        $model->save();
        return $model;
    }

    public function checkIfUserHasActiveSubscription(User $user): bool
    {
        return PremiumUserSubscription::where('user_id', '=', $user->id)->where('end_date', '>', Carbon::now())->exists();
    }
}