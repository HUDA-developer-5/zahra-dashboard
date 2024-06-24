@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.My Commissions')])
        <div id="my-ads" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu', ['title' => trans('web.My Commissions')])

                    <div class="col-lg-9">
                        <div class="commissions-details">
                            @if($commissions->count())
                                <div class="mb-3">
                                    <a href="javascript:void(0);"
                                       data-amount="{{ $commissions->where('is_paid', '=', 0)->sum('commission') }}"
                                       data-id="all"
                                       class="btn btn-gradiant btn-pay-commission fw-bold payCommissionBTN">{{ trans('web.Pay all commissions') }}</a>
                                </div>
                                @foreach($commissions as $commission)
                                    <div class="card mb-3">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                            <p class="fw-600 mb-0">{{ $commission->advertisement?->name }}</p>
                                            @if($commission->is_paid)
                                                <p class="text-success payed">
                                                    <span class="me-1"><i class="far fa-circle-check"></i></span>
                                                    <span>{{ trans('web.Paid') }}</span>
                                                </p>
                                            @else
                                                <a href="javascript:void(0);"
                                                   data-amount="{{ $commission->commission }}"
                                                   data-id="{{ $commission->id }}"
                                                   class="btn btn-border btn-pay fw-bold payCommissionBTN">
                                                    <span>{{ trans('web.Pay') }}</span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="text-gray fw-600 mb-0">{{ trans('web.Price') }}</p>
                                                <p class="text-primary fw-600 fs-5">{{ $commission->amount }} {{ \Illuminate\Support\Str::upper($commission->currency) }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-gray fw-600 mb-0">{{ trans('web.Commission') }}</p>
                                                <p class="text-secondary fw-600 fs-5">{{ $commission->commission }} {{ \Illuminate\Support\Str::upper($commission->currency) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card mb-3">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                        <p class="fw-600 mb-0">{{ trans('web.No data found') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal main-modal addNewCardModal fade" id="addNewCardModal" aria-hidden="true" tabindex="-1">
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
                    {{ html()->form('post', route('web.my-commissions.pay'))->open() }}
                    <div class="d-flex justify-content-between mb-3 check-form">
                        <label class="form-check-label" for="wallet">
                            <img src="{{ asset('frontend/assets/images/icons/wallet.svg') }}" alt="wallet icon">
                            <span>{{ trans('web.Pay by wallet') }} <span
                                        class="text-success amountNeedToPay"></span></span>
                        </label>
                        <input class="form-check-input" type="radio" name="payment_type" id="wallet" value="wallet"
                               checked>

                        {{ html()->hidden('commission_id')->id("commissionIdInput") }}
                    </div>
                    <div class="d-flex justify-content-between mb-3 check-form">
                        <label class="form-check-label" for="byCard">
                            <img src="{{ asset('frontend/assets/images/icons/card.svg') }}" alt="card icon">
                            <span>{{ trans('web.Pay by Card') }}</span>
                        </label>
                        <input class="form-check-input" type="radio" name="payment_type" id="byCard" value="card">
                    </div>
                    @if($errors->commission->has("payment_type"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->commission->first("payment_type") }}</span>
                        </div>
                    @endif
                    @if($errors->commission->has("commission_id"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->commission->first("commission_id") }}</span>
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
@stop

@section("script")
    <script>
        $(document).ready(function () {
            $('.payCommissionBTN').on('click', function () {
                let amount = $(this).data('amount');
                let id = $(this).data('id');
                $("#commissionIdInput").val(id);
                let currency = '{{ auth()->user()->default_currency }}';
                $('.amountNeedToPay').text("(" + amount + currency + ")");
                $('#addNewCardModal').modal('show');
            });

            @if($errors->commission->count())
            $('#addNewCardModal').modal('show');
            @endif
        })
    </script>
@endsection
