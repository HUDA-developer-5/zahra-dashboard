<?php

namespace App\Http\Controllers\Web;

use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\CommissionPayWithTypesEnums;
use App\Enums\CommonStatusEnums;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advertisement\AdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\CommentAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\FilterAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\ReportAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\UpdateAdvertisementApiRequest;
use App\Http\Requests\Api\PayCommissionByCardRequest;
use App\Http\Requests\Api\PayPremiumSubscriptionByCardRequest;
use App\Http\Requests\Api\PayPremiumSubscriptionRequest;
use App\Http\Requests\Api\RechargeWalletRequest;
use App\Http\Resources\Api\CityApiResource;
use App\Http\Resources\Api\StateApiResource;
use App\Models\City;
use App\Models\Nationality;
use App\Models\State;
use App\Services\Advertisement\AdvertisementService;
use App\Services\CategoryService;
use App\Services\DynamicPageService;
use App\Services\NationalityService;
use App\Services\PayCommissionService;
use App\Services\PayPremiumUserSubscriptionService;
use App\Services\User\PaymentService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PaymentWebController extends Controller
{
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');

        // add payment method to stripe user
        $user = auth('users')->user();
        $userService = new UserService();
        $userService->addPaymentMethod($user, $paymentMethod);
        toastr()->success(trans('web.PaymentMethod received successfully'));
        return response()->json(['message' => trans('web.PaymentMethod received successfully')]);
    }

    public function submitChargeWallet(RechargeWalletRequest $request)
    {
        $user = auth('users')->user();
//        $currency = $user->default_currency;
        $country_id = session()->get('country_id') ?? 2;
        $currency = Nationality::where('id', $country_id)->first()->currency;

        $returnPaymentTransactionDTO = (new PaymentService())->chargeWallet($user, $request->get('amount'), $request->get('payment_method'), $currency);

        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            toastr()->success(trans('api.PaymentSuccess'));
        } else {
            toastr()->error(trans('api.PaymentFailed'));
        }

        return redirect()->route('wallet');
    }

    public function submitPayMyCommissionWithCard(PayCommissionByCardRequest $request)
    {
        $user = auth('users')->user();
        return (new PayCommissionService())->payCommissionByCard($user, $request->get('payment_method'), $request->get('id'));
    }

    public function payPremiumSubscription(PayPremiumSubscriptionRequest $request)
    {
        $user = auth('users')->user();
        $payPremiumUserSubscriptionService = new PayPremiumUserSubscriptionService();
        return $payPremiumUserSubscriptionService->paySubscription($user, CommissionPayWithTypesEnums::from($request->get('payment_type')));
    }

    public function payPremiumSubscriptionWithCard()
    {
        $userService = new UserService();
        // list user payment methods from stripe
        $user = auth('users')->user();
        $cards = $userService->listUserCards($user);
        $intent = $userService->createSetupIntent($user);
        $premiumUserSetting = (new DynamicPageService())->getPremiumSetting();
        return view('frontend.profile.pay_premium_subscription_by_card')->with([
            'intent' => $intent->client_secret,
            'cards' => $cards,
            'premiumUserSetting' => $premiumUserSetting,
        ]);
    }

    public function submitPremiumSubscriptionWithCard(PayPremiumSubscriptionByCardRequest $request)
    {
        $user = auth('users')->user();
        return (new PayPremiumUserSubscriptionService())->payByCard($user, $request->get('payment_method'));
    }
}
