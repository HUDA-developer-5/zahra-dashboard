@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.My Cards')])
        <div id="my-ads" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu')

                    <div class="col-lg-9">
                        <div class="cards-details">

                            @if($cards->count())
                                @foreach($cards as $card)
                                    <div class="card mb-3">
                                        <div class="d-flex justify-content-between align-items-center check-form border-0 p-0">
                                            <label class="form-check-label w-75 d-sm-flex flex-wrap justify-content-between align-items-center gap-3 " for="premiumAd">
                                                <div class="img mb-2 mb-sm-0">
                                                    @if($card->brand == "visa")
                                                        <img src="{{ asset('frontend/assets/images/visa-logo.svg') }}" alt="visa logo">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/images/master-card.svg') }}" alt="master-card logo">
                                                    @endif
                                                </div>
                                                <div class="mb-2 mb-sm-0">
                                                    <p class="mb-0 fw-400">{{ $card->name }} </p>
                                                    <p class="mb-0 fw-400 text-gray">*{{ $card->last_four_numbers }}</p>
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-400">{{ trans('web.Date Expire') }}</p>
                                                    <p class="mb-0 fw-400 text-gray">{{ $card->expire_month }}/{{ $card->expire_year }}</p>
                                                </div>
                                            </label>
                                            <input class="form-check-input" type="radio" name="adType" id="premiumAd" value="2">
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="text-sm-end">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewCardModal" class="btn btn-gradiant btn-confirm d-block d-sm-inline-block fw-bold p-3 px-5">
                                    <i class="fas fa-plus"></i>
                                    <span>{{ trans('web.Add new Card') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.add_payment_card')
@stop

@section("script")

@endsection
