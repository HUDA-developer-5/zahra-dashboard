<?php

namespace App\Services;

use App\DTOs\User\CreateWalletTransactionDTO;
use App\DTOs\User\PayCommissionDTO;
use App\DTOs\User\PaymentTransactionDTO;
use App\Enums\CommissionPayWithTypesEnums;
use App\Enums\User\PaymentMethodsEnum;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Enums\User\PaymentTransactionTypesEnum;
use App\Enums\User\WalletTransactionTypesEnum;
use App\Models\Advertisement;
use App\Models\User;
use App\Services\User\PaymentService;
use App\Services\User\WalletTransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PayCommissionService
{
    public function payCommission(User $user, PayCommissionDTO $payCommissionDTO): RedirectResponse
    {
        // check commission id (all or id) and related to logged-in user
        if ($payCommissionDTO->payment_type->value == CommissionPayWithTypesEnums::Card->value) {
            return redirect()->route('web.my-commissions.payWithCard', ['id' => $payCommissionDTO->commission_id]);
        }

        $totalAmount = $this->getCommissionAmount($user, $payCommissionDTO->commission_id);
        if ($totalAmount == 0) {
            toastr()->warning(trans('api.no commission found'));
            return redirect()->route('web.my-commissions.list');
        }

        $response = $this->payCommissionByWallet($user, $totalAmount);
        if ($response['status']->value == PaymentTransactionStatusEnum::Completed->value) {
            $this->markCommissionAsPaid($user, $payCommissionDTO->commission_id, $response['transactionId']);
            toastr()->success(trans('api.paid successfully'));
        } else {
            toastr()->warning(trans('api.not enough balance'));
        }
        return redirect()->route('web.my-commissions.list');
    }

    public function mobilePayCommissionByWallet(User $user, $commission_id_all): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $totalAmount = $this->getCommissionAmount($user, $commission_id_all);
        if ($totalAmount == 0) {
            return [
                'message' => trans('api.no commission found'),
                'status' => $status
            ];
        }

        $response = $this->payCommissionByWallet($user, $totalAmount);
        if ($response['status']->value == PaymentTransactionStatusEnum::Completed->value) {
            $this->markCommissionAsPaid($user, $commission_id_all, $response['transactionId']);
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

    public function mobilePayCommissionByCard(User $user, $paymentMethod, $commissionId): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $totalAmount = $this->getCommissionAmount($user, $commissionId);
        if ($totalAmount == 0) {
            return [
                'message' => trans('api.no commission found'),
                'status' => $status
            ];
        }

        $currency = $user->default_currency;
        $returnPaymentTransactionDTO = (new PaymentService())->payCommission($user, $totalAmount, $paymentMethod, $currency);
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $this->markCommissionAsPaid($user, $commissionId, $returnPaymentTransactionDTO->payment_transaction_id);
            $message = trans('api.paid successfully');
            $status = PaymentTransactionStatusEnum::Completed;
        } else {
            toastr()->warning(trans('api.PaymentFailed'));
            $message = trans('api.PaymentFailed');
        }
        return [
            'message' => $message,
            'status' => $status
        ];
    }

    public function payCommissionByWallet(User $user, $totalAmount): array
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $transactionId = null;
        // check the wallet amount
        $walletBalance = $user->balance;
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
                'type' => PaymentTransactionTypesEnum::PayCommission,
                'status' => PaymentTransactionStatusEnum::Completed,
                'amount' => $totalAmount,
                'currency' => $currency,
                'user_id' => $user->id,
                'description' => 'Pay Commission from Wallet with ' . $totalAmount . ' ' . $currency . ' using ' . PaymentMethodsEnum::Wallet->value,
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

    public function payCommissionByCard(User $user, $paymentMethod, $commissionId)
    {
        $totalAmount = $this->getCommissionAmount($user, $commissionId);
        if ($totalAmount == 0) {
            toastr()->warning(trans('api.no commission found'));
            return redirect()->route('web.my-commissions.list');
        }

        $currency = $user->default_currency;
        $returnPaymentTransactionDTO = (new PaymentService())->payCommission($user, $totalAmount, $paymentMethod, $currency);
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $this->markCommissionAsPaid($user, $commissionId, $returnPaymentTransactionDTO->payment_transaction_id);
            toastr()->success(trans('api.paid successfully'));
        } else {
            toastr()->warning(trans('api.PaymentFailed'));
            return redirect()->route('web.my-commissions.payWithCard', ['id' => $commissionId]);
        }
        return redirect()->route('web.my-commissions.list');
    }

    public function getCommissionAmount(User $user, $commissionId)
    {
        $totalAmount = 0;
        if ($commissionId == 'all') {
            // get all user commissions not paid amount
            $notPaidCommissions = $this->getUserNotPaidCommissions($user);
            if ($notPaidCommissions->count()) {
                $totalAmount = $notPaidCommissions->sum('commission');
            }
        } else {
            // get user commission by ID
            $commission = $this->getUserNotPaidCommission($user, $commissionId);
            if ($commission) {
                $totalAmount = $commission->commission;
            }
        }
        return $totalAmount;
    }

    protected function markCommissionAsPaid(User $user, $commissionId, $transactionId): bool
    {
        if ($commissionId == 'all') {
            // get all user commissions not paid amount
            $user->commissions()
                ->where('is_paid', '=', 0)
                ->update(['is_paid' => 1, 'payment_transaction_id' => $transactionId]);
        } else {
            // get user commission by ID
            $user->commissions()->where('id', '=', $commissionId)->update(['is_paid' => 1, 'payment_transaction_id' => $transactionId]);
        }
        return true;
    }

    public function getUserNotPaidCommissions(User $user)
    {
        return $user->commissions()
            ->where('is_paid', '=', 0)
            ->get();
    }

    public function getUserNotPaidCommission(User $user, int $id)
    {
        return $user->commissions()
            ->where('id', '=', $id)
            ->where('is_paid', '=', 0)
            ->first();
    }

    public function addCommissionToUserProduct(User $user, Advertisement $advertisement)
    {
        // check if the user is premium
        // get commission amount based on product type
        // create commission

    }

    public function getPremiumCommission()
    {
        
    }
}