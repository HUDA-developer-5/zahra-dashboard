@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.Pay by Card')])
        <div id="my-ads" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu', ['title' => trans('web.Pay by Card')])

                    <div class="col-lg-9">
                        <div class="wallet-details">
                            <div class="card-gradient mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center details">
                                    <div class="info">
                                        <h6 class="fw-400">{{ trans('web.Amount') }}</h6>
                                        <p class="fs-5 fw-bold mb-0">{{ $premiumUserSetting->price }} {{ \Illuminate\Support\Str::upper(auth('users')->user()->default_currency) }}</p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)"
                                           class="btn btn-white text-primary btn-recharge fw-600">{{ trans('web.Pay') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="wallet-recharge d-none">
                                <div class="card mb-3">
                                    <p class="fw-600 mb-1">{{ trans('web.Pay') }} :</p>
                                    @if($cards->count())
                                        @foreach($cards as $card)
                                            <div class="card mb-3">
                                                <div class="d-flex justify-content-between align-items-center check-form border-0 p-0">
                                                    <label class="form-check-label w-75 d-sm-flex flex-wrap justify-content-between align-items-center gap-3 "
                                                           for="premiumAd">
                                                        <div class="img mb-2 mb-sm-0">
                                                            @if($card->brand == "visa")
                                                                <img src="{{ asset('frontend/assets/images/visa-logo.svg') }}"
                                                                     alt="visa logo">
                                                            @else
                                                                <img src="{{ asset('frontend/assets/images/master-card.svg') }}"
                                                                     alt="master-card logo">
                                                            @endif
                                                        </div>
                                                        <div class="mb-2 mb-sm-0">
                                                            <p class="mb-0 fw-400">{{ $card->name }} </p>
                                                            <p class="mb-0 fw-400 text-gray">
                                                                *{{ $card->last_four_numbers }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 fw-400">{{ trans('web.Date Expire') }}</p>
                                                            <p class="mb-0 fw-400 text-gray">{{ $card->expire_month }}
                                                                /{{ $card->expire_year }}</p>
                                                        </div>
                                                    </label>
                                                    <input class="form-check-input payment_method" type="radio"
                                                           name="payment_method" value="{{ $card->id }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-end">
                                    @if($cards->count())
                                        <button class="btn btn-gradiant btn-confirm fw-bold confirmButton">{{ trans('web.Confirm') }}</button>
                                    @else
                                        <button data-bs-toggle="modal"
                                           data-bs-target="#addNewCardModal"
                                           class="btn btn-gradiant btn-confirm fw-bold">
                                            <i class="fas fa-plus"></i>
                                            <span>{{ trans('web.Add new Card') }}</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal main-modal rechargeConfirmModal fade" id="rechargeConfirmModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header justify-content-center border-0">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                    </button>
                    <div class="text-center">
                        <h3 class="text-capitalize text-center fw-bold mb-0">{{ trans('web.Pay By') }}</h3>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div class="text-end mb-3">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewCardModal"
                           class="d-block d-sm-inline-block text-primary fw-bold">
                            <i class="fas fa-plus"></i>
                            <span>{{ trans('web.Add new Card') }}</span>
                        </a>
                    </div>
                    {{ html()->form('post', route('web.premium.payWithCard.submit'))->open() }}
                    <div class="d-flex justify-content-between mb-3">
                        <input id="amount" class="form-control" type="number" disabled
                               placeholder="{{ trans('web.Amount') }}" name="amount" value="{{ $premiumUserSetting->price }}"/>
                        {{ html()->hidden('payment_method')->id('paymentMethodInput') }}
                    </div>
                    @if($errors->premium_subscription->has("payment_method"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->premium_subscription->first("payment_method") }}</span>
                        </div>
                    @endif
                    <div class="d-flex gap-2">
                        <button class="btn btn-gradiant py-3 w-50"><span
                                    class="fw-bold">{{ trans('web.Confirm') }}</span></button>
                        <a class="btn btn-border py-3 w-50" data-bs-dismiss="modal" aria-label="Close"><span
                                    class="fw-bold">{{ trans('web.Cancel') }}</span> </a>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.add_payment_card')

@stop

@section("script")
    <script>
        $(document).ready(function () {
            $('.confirmButton').on('click', function () {
                // check if the payment method is selected
                if ($('input[name="payment_method"]:checked').length == 0) {
                    $('#rechargeConfirmModal').modal('hide');
                    alert('{{ trans('web.Please select a payment method') }}');
                } else {
                    $('#paymentMethodInput').val($('input[name="payment_method"]:checked').val());
                    $('#rechargeConfirmModal').modal('show');
                }
            })
            @if($errors->premium_subscription->count())
                $('#rechargeConfirmModal').modal('show');
            @endif
        });
    </script>
@endsection
