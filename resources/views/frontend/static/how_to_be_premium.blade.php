@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.How to be Premium')])

        <div id="about-us" class="mb-5">
            <div class="container">
                <div class="card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-7 order-2 order-md-1 text-center text-md-start">
                            <h2 class="fw-bold mb-3">{{ $dynamicPage->{"title_".app()->getLocale()} }}</h2>
                            {!! $dynamicPage->{"content_".app()->getLocale()} !!}
                            @auth('users')
                                <div>
                                    <a data-bs-toggle="modal" href="#payModal" role="button"
                                       class="btn btn-gradiant py-3 px-4">{{ trans('web.Pay to be Special') }}</a>
                                </div>
                            @endauth
                        </div>
                        <div class="col-md-5 order-1 order-md-2 mb-3 mb-md-0">
                            <div class="img text-center">
                                <img src="{{ asset('frontend/assets/images/about-img.png') }}" alt="about image"
                                     class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @auth('users')
        @if(isset($premiumUserSetting))
            <div class="modal main-modal payModal fade" id="payModal" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header justify-content-center border-0">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                            </button>
                            <div class="text-center">
                                <div class="modal-logo mb-2">
                                    <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon"
                                         loading="lazy">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body pt-0">
                            <h3 class="fw-bold text-center mb-3"> {{ trans('web.To confirm, please pay') }} <span
                                        class="text-primary">{{ $premiumUserSetting->price }}</span><span
                                        class="fs-7">{{ auth('users')->user()->default_currency }}</span>
                            </h3>
                            <div class="d-flex gap-2">
                                <a data-bs-toggle="modal" href="#paybyModal" role="button"
                                   class="btn btn-gradiant py-2 w-50"><span
                                            class="fw-bold">{{ trans('web.Confirm') }}</span> </a>
                                <button class="btn btn-border py-2 w-50" data-bs-dismiss="modal"
                                        aria-label="Close"><span
                                            class="fw-bold">{{ trans('web.Cancel') }}</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal main-modal fade" id="paybyModal" aria-hidden="true" tabindex="-1">
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
                        <div class="modal-body">
                            {{ html()->form('post', route('web.pay.premium'))->open() }}
                            <div class="d-flex justify-content-between mb-3 check-form">
                                <label class="form-check-label" for="wallet">
                                    <img src="{{ asset('frontend/assets/images/icons/wallet.svg') }}" alt="wallet icon">
                                    <span>{{ trans('web.Pay by wallet') }} <span
                                                class="text-success">({{ $premiumUserSetting->price .' '. auth('users')->user()->default_currency }})</span></span>
                                </label>
                                <input class="form-check-input" type="radio" name="payment_type" id="wallet"
                                       value="wallet"
                                       checked>
                            </div>
                            <div class="d-flex justify-content-between mb-3 check-form">
                                <label class="form-check-label" for="byCard">
                                    <img src="{{ asset('frontend/assets/images/icons/card.svg') }}" alt="card icon">
                                    <span>{{ trans('web.Pay by Card') }}</span>
                                </label>
                                <input class="form-check-input" type="radio" name="payment_type" id="byCard"
                                       value="card">
                            </div>
                            @if($errors->premium_subscription->has("payment_type"))
                                <div class="error-note">
                                    <span class="help-block text-danger">{{ $errors->premium_subscription->first("payment_type") }}</span>
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

        @endif
    @endauth
@stop

@section("script")
    <script>
        $(document).ready(function () {
            @if($errors->premium_subscription->count())
            $('#paybyModal').modal('show');
            @endif
        })
    </script>
@endsection
