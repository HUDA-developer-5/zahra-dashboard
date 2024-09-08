@extends('frontend.layouts.master')

@section("style")
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/ajax-file-uploader/css/jquery.uploader.css') }}">
@endsection

@section('content')
    <div id="main-wrapper">
        @includeIf('frontend.components.top_title', ['title' => trans('web.Share your ads')])

        <div id="share-ads" class="mb-5">
            <div class="container">
                <div class="card form-wizard">
                    <h3 class="fw-bold mb-4">{{ trans('web.Add advertisement') }} </h3>
                    @if ($errors->add_product->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->add_product->all() as $error)
                                    <li>-{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{ html()->form('post', route('web.products.save'))->id("addProductForm")->class('form-wizard')->acceptsFiles()->open() }}
                    <div>
                        <fieldset class="wizard-fieldset add_info show">
                            <div class="title">
                                <h4 class="fw-bold">{{ trans('web.Upload attachments') }} </h4>
                                <p class="text-gray">{{ trans('web.You can add up to 20 images or videos.') }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product image') }}</h6>
                                    <p> (<span class="text-secondary">1</span>)</p>
                                </div>
                                <div>
                                    <input name="image" type="file" value="" required>
                                </div>
                            </div>
                            <div id="pro_images" class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product images') }}</h6>
{{--                                    <p> (<span class="text-secondary">0</span>/20)</p>--}}
                                    <p> (<span class="text-secondary" id="imageCount">0</span>/20)</p>
                                </div>
                                <div>
                                    <input name="images[]" type="file" id="upload_File" value="" multiple>
                                </div>
                            </div>
                            <div id="pro_videos" class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product Video') }} <span
                                            class="text-gray">( {{ trans('web.optional') }} )</span></h6>
{{--                                    <p> (<span class="text-secondary">0</span>/20)</p>--}}
                                    <p> (<span class="text-secondary" id="videoCount">0</span>/20)</p>

                                </div>
                                <div>
                                    <input name="videos[]" type="file" id="upload_video" value="" multiple>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="wizard-fieldset add_info_2 hide">
                            <div class="title">
                                <h5 class="fw-bold mb-3">{{ trans('web.Add Info') }}</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3" id="categorySelects">
                                    <div class="sec-select">
                                        <select class="select2 w-100 form-control" name="category_id" id="category_id"
                                                required>
                                            <option value="" selected
                                                    disabled>{{ trans('web.Select Category') }}</option>
                                            @foreach($allCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3" id="subCategorySelects"></div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        <input type="text" id="info-title" name="name" class="form-control" required
                                               placeholder="{{ trans('web.Title') }}" maxlength="50"
                                               value="{{ old('name') }}">
                                        <label class="form-label" for="info-title">{{ trans('web.Title') }}</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-input">
                                            <textarea name="description" id="info-desc" rows="5" required
                                                      value="{{ old('description') }}"
                                                      placeholder="{{ trans('web.Description') }}"
                                                      class="form-control"
                                                      maxlength="1024">{{  old('description')}}</textarea>
                                        <label class="form-label" for="info-desc">{{ trans('web.Description') }}</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <select class="form-select" id="priceType" name="price_type" required
                                            value="{{ old('price_type') }}">
                                        @foreach($price_types as $key => $price_type)
                                            <option value="{{ $key }}"> {{ $price_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="price" id="fixedPrice">
                                        <div class="form-input">
                                            <input type="text" id="info-price" name="price"
                                                   value="{{ old('price') }}"
                                                   class="form-control input-with-currency"
                                                   placeholder="{{ trans('web.Price') }}">
                                            <label class="form-label" for="info-price">{{ trans('web.Price') }}</label>
                                        </div>
                                        <div class="currency">
                                            <select class="form-select" name="currency" value="{{ old('currency') }}">
                                                @foreach($countries as $country)
                                                    <option
                                                        value="{{ $country->currency }}"> {{ $country->currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-none" id="offerPrice">
                                        <div class="d-flex gap-3">
                                            <div class="w-50">
                                                <div class="form-input">
                                                    <input type="text" id="info-min-price" name="min_price"
                                                           class="form-control"
                                                           value="{{ old('min_price') }}"
                                                           placeholder="{{  trans('web.Min Price') }}">
                                                    <label class="form-label"
                                                           for="info-min-price">{{  trans('web.Min Price') }}</label>
                                                </div>
                                            </div>
                                            <div class="price w-50">
                                                <div class="form-input">
                                                    <input type="text" id="info-max-price" name="max_price"
                                                           class="form-control input-with-currency"
                                                           value="{{ old('max_price') }}"
                                                           placeholder="{{  trans('web.Max Price') }}">
                                                    <label class="form-label"
                                                           for="info-max-price">{{  trans('web.Max Price') }}</label>
                                                </div>
                                                <div class="currency">
                                                    <select class="form-select" name="currency"
                                                            value="{{ old('currency') }}">
                                                        @foreach($countries as $country)
                                                            <option
                                                                value="{{ $country->currency }}"> {{ $country->currency }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        <input type="text" id="info-phone" name="phone_number" class="form-control"
                                               required
                                               placeholder="{{ trans('web.Phone number') }}"
                                               value="{{ old('phone_number') }}">
                                        <label class="form-label"
                                               for="info-phone">{{ trans('web.Phone number') }}</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        <input type="text" id="info-whatapp-num" name="whatsapp_number" required
                                               value="{{ old('whatsapp_number') }}"
                                               class="form-control" placeholder="{{ trans('web.Whatsapp number') }}">
                                        <label class="form-label"
                                               for="info-whatapp-num">{{ trans('web.Whatsapp number') }}</label>
                                    </div>
                                </div>

                                <div class="title">
                                    <h5>{{ trans('web.Is Negotiable') }}</h5>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label">
                                            {{ trans('web.Yes') }}
                                        </label>
                                        {{ html()->radio('is_negotiable',null, 1)->addClass('form-check-input') }}
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label">
                                            <span>{{ trans('web.No') }}</span>
                                        </label>
                                        {{ html()->radio('is_negotiable', null, 0)->addClass('form-check-input') }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="wizard-fieldset add_address_info hide">
                            <div class="title">
                                <h5>{{ trans('web.Add Address Info') }}</h5>
                            </div>
                            <div class="row">
                                <div class="validationErrors alert alert-danger d-none">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select class="select2 w-100 form-control" name="nationality_id" id="nationalityId"
                                            required
                                            value="{{ old('nationality_id') }}">
                                        <option label="{{ trans('web.Select Country') }}"></option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select class="select2 w-100 form-control" name="state_id" id="stateList" required
                                            value="{{ old('state_id') }}">

                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select class="select2 w-100 form-control" name="city_id" id="cityList" required
                                            value="{{ old('city_id') }}">

                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div id="map"></div>
                                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label" for="normalAd">
                                            {{ trans('web.Normal ad') }}
                                        </label>
                                        <input class="form-check-input" type="radio" name="type" id="normalAd" checked
                                               value="free">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label" for="premiumAd">
                                            <img src="{{ asset('frontend/assets/images/icons/crown.svg') }}"
                                                 alt="crown icon">
                                            <span>{{ trans('web.Premium') }}</span>
                                        </label>
                                        <input class="form-check-input" type="radio" name="type" id="premiumAd"
                                               value="premium">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="premium-info mb-3 d-none">
                                        <div>
                                            <img src="{{ asset('frontend/assets/images/icons/info-circle.svg') }}"
                                                 alt="info circle">
                                            <span
                                                class="fw-bold">{{ $premiumDetails->{"title_". app()->getLocale()} }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap mb-2">
                                            {!! $premiumDetails->{"content_". app()->getLocale()} !!}
                                        </div>
                                        <div class="amount">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="form-input mb-2">
                                                    <input type="number" id="premiumAmount" name="premium_amount"
                                                           class="form-control"
                                                           placeholder="{{ trans('web.Enter amount') }}" min="1">
                                                    <label class="form-label"
                                                           for="premiumAmount">{{ trans('web.Enter amount') }}</label>
                                                </div>
                                            </div>
                                            <p class="premium-info-text"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="d-flex align-items-center gap-3 my-3 form-btns">
                        <a href="javascript:void(0)" class="btn form-wizard-previous-btn"
                           disabled>{{ trans('web.Previous') }}</a>
                        <div id="progressbar" class="flex-grow-1">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <a href="javascript:void(0)"
                           class="btn btn-gradiant form-wizard-next-btn">{{ trans('web.Next') }}</a>
                        <a id="confirmFormBtn" href="javascript:void(0)"
                           class="btn btn-gradiant form-wizard-confirm-btn d-none">{{ trans('web.Confirm') }}</a>
                    </div>

                    <input type="hidden" name="submit_type" id="submitType" value="validation">
                    <input type="hidden" name="payment_type" id="paymentType" value="wallet">
                    <input type="hidden" name="payment_method" id="paymentMethod" value="">
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>

        <div class="modal main-modal confirmModal fade" id="confirmModal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header justify-content-center border-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                        </button>
                        <div class="text-center">
                            <div class="modal-logo">
                                <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon"
                                     loading="lazy">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="text-center fw-bold mb-3">
                            <h3>{{ trans('web.To confirm, please pay') }}</h3>
                            <p>
                                <span
                                    class="text-primary payPremiumAmount"></span>{{ auth('users')->user()->default_currency }}
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a data-bs-toggle="modal" href="#payByModal" role="button"
                               class="btn btn-gradiant py-3 w-50"><span
                                    class="fw-bold">{{ trans('web.Confirm') }}</span> </a>
                            <a class="btn btn-border py-3 w-50" data-bs-dismiss="modal" aria-label="Close"><span
                                    class="fw-bold">{{  trans('web.Cancel') }}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal main-modal payByModal fade" id="payByModal" aria-hidden="true" tabindex="-1">
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
                        <div class="d-flex justify-content-between mb-3 check-form">
                            <label class="form-check-label" for="payWallet">
                                <img src="{{ asset('frontend/assets/images/icons/wallet.svg') }}" alt="wallet icon">
                                <span>{{ trans('web.Pay by wallet') }} <span class="text-success">({{  auth('users')->user()->wallet_balance }})</span></span>
                            </label>
                            <input class="form-check-input" type="radio" name="payWay" id="payWallet" value="wallet"
                                   checked>
                        </div>
                        <div class="d-flex justify-content-between mb-3 check-form">
                            <label class="form-check-label" for="payCard">
                                <img src="{{ asset('frontend/assets/images/icons/card.svg') }}" alt="card icon">
                                <span>{{ trans('web.Pay by Card') }}</span>
                            </label>
                            <input class="form-check-input" type="radio" name="payWay" id="payCard" value="card">
                        </div>

                        @if($cards->count())
                            <div class="mb-3 d-none" id="cardList">

                                @foreach($cards as $card)
                                    <div class="card mb-3">
                                        <div
                                            class="d-flex justify-content-between align-items-center check-form border-0 p-0">
                                            <label
                                                class="form-check-label w-75 d-sm-flex flex-wrap justify-content-between align-items-center gap-3 "
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
                                            <input class="form-check-input payment_method_id" type="radio"
                                                   name="payment_method_id" value="{{ $card->id }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @endif
                        <div class="d-flex gap-2">
                            <a href="#" id="submitConfirmPay" class="btn btn-gradiant py-3 w-50"><span
                                    class="fw-bold">{{  trans('web.Confirm') }}</span> </a>
                            <a class="btn btn-border py-3 w-50" data-bs-dismiss="modal" aria-label="Close"><span
                                    class="fw-bold">{{ trans('web.Cancel') }}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal main-modal successModal fade" id="successModal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header justify-content-center border-0 p-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{  asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('frontend/assets/images/icons/success.svg') }}" alt="success img"
                                 class="mb-3">
                            <p class="fw-bold">{{ trans('web.Your add published successfully') }}</p>
                        </div>
                        <form>
                            <div class="d-flex gap-2">
                                <a class="btn btn-gradiant py-3 w-50" href="{{  route('web.products.add')}}"><span
                                        class="fw-bold">{{ trans('web.Add New Advertisement') }}</span>
                                </a>
                                <a class="btn btn-border py-3 w-50" data-bs-dismiss="modal" aria-label="Close"><span
                                        class="fw-bold">{{  trans('web.Cancel') }}</span> </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @stop

        @section("script")
            <script src="{{ asset('frontend/assets/js/map.js') }}"></script>
            <script
                src="{{ asset('frontend/assets/plugins/ajax-file-uploader/dist/jquery.uploader.min.js') }}"></script>
            <script>
                $(document).ready(function () {

                    @if(session()->has('advertisement_published') && session()->get('advertisement_published') == true)
                    $('#successModal').modal('show');
                    @endif

                    // $("#confirmFormBtn").click(function () {
                    //     var productType = $("input[name='type']:checked").val();
                    //     if (productType == 'free') {
                    //         $("#addProductForm").submit();
                    //     }
                    //
                    //     if (productType == 'premium') {
                    //         // show confirm modal
                    //         $("#confirmModal").modal('show');
                    //     }
                    // });

                    $("#submitConfirmPay").click(function () {
                        $("#addProductForm").submit();
                    });


                    $('input[type=radio][name=type]').change(function () {
                        var selectedValue = $(this).val();
                        if (selectedValue == 'premium') {
                            $("#premiumAmount").prop('required', true);
                            $('.form-wizard-confirm-btn').addClass('d-none');
                        }

                        if (selectedValue == 'free') {
                            $("#premiumAmount").prop('required', false);
                            $("#premiumAmount").val("");
                            $(".premium-info-text").text("");
                            $('.form-wizard-confirm-btn').removeClass('d-none');
                        }
                    });

                    $("#payCard").click(function () {
                        $('#paymentType').val("card");
                        $('#cardList').removeClass('d-none');
                    });

                    $(".payment_method_id").click(function () {
                        $('#paymentMethod').val($(this).val());
                    });

                    $("#payWallet").click(function () {
                        $('#paymentType').val("wallet");
                        $('#paymentMethod').val("");
                        $('#cardList').addClass('d-none');
                    });

                    {{--$('#addProductForm').submit(function (e) {--}}
                    {{--    e.preventDefault();--}}
                    {{--    var formData = new FormData(this);--}}
                    {{--    $.ajax({--}}
                    {{--        url: "{{ route('web.products.save') }}",--}}
                    {{--        type: 'POST',--}}
                    {{--        data: formData,--}}
                    {{--        success: function (response) {--}}
                    {{--            if (response.premium == false) {--}}
                    {{--                // refresh the page--}}
                    {{--                window.location.reload();--}}
                    {{--            } else {--}}
                    {{--                // Handle success response--}}
                    {{--                $("#product_id").val(response.product_id);--}}
                    {{--            }--}}
                    {{--        },--}}
                    {{--        error: function (xhr, status, error) {--}}
                    {{--            var errorResponse = JSON.parse(xhr.responseText);--}}
                    {{--            var errorList = "<ul>";--}}
                    {{--            $.each(errorResponse.errors, function (key, value) {--}}
                    {{--                errorList += "<li>" + value.join(", ") + "</li>";--}}
                    {{--            });--}}
                    {{--            errorList += "</ul>";--}}
                    {{--            $(".validationErrors").html(errorList);--}}
                    {{--            $(".validationErrors").removeClass('d-none');--}}
                    {{--        },--}}
                    {{--        cache: false,--}}
                    {{--        contentType: false,--}}
                    {{--        processData: false--}}
                    {{--    });--}}
                    {{--});--}}

                    $("#premiumAmount").change(function () {
                        // call ajax call to get the discount and display it
                        var premiumAmount = $(this).val();
                        var url = "{{ url()->route('web.products.getPremiumDiscount', ['amount' => ':premiumAmount']) }}";
                        if (premiumAmount) {
                            $('.form-wizard-confirm-btn').removeClass('d-none');
                            $.ajax({
                                type: "GET",
                                url: url.replace(':premiumAmount', premiumAmount),
                                success: function (data) {
                                    $('.premium-info-text').html(data.data);
                                    $('.payPremiumAmount').text(data.amount_after_commission);
                                    $('#premiumAmount').val(premiumAmount);
                                }
                            });
                        } else {
                            $('.form-wizard-confirm-btn').addClass('d-none');
                        }
                    });

                    $('.form-wizard .wizard-fieldset .check-form input[type="radio"]').change(function () {
                        let checkInputVal = $(this).val();
                        if (checkInputVal == 'premium')
                            $('.form-wizard .wizard-fieldset .premium-info').removeClass('d-none');
                        else
                            $('.form-wizard .wizard-fieldset .premium-info').addClass('d-none');
                    });


                    let current = 1;
                    let steps = $("fieldset").length;

                    function setProgressBar(curStep) {
                        let percent = parseFloat(100 / steps) * curStep;
                        percent = percent.toFixed();
                        $(".progress-bar").css("width", percent + "%");
                        $(".progress-bar").closest('#progressbar').find('.steps span').text(curStep);
                    }

                    setProgressBar(current);
                    // click on next button
                    $('.form-wizard-next-btn').click(function () {
                        let next = $(this);
                        let currentFieldset = next.closest('.form-wizard').find('.wizard-fieldset.show');
                        let nextWizardStep = true;
                        currentFieldset.find('.wizard-required').each(function () {
                            let thisValue = $(this).val();

                            if (thisValue == "") {
                                $(this).siblings(".wizard-form-error").slideDown();
                                nextWizardStep = false;
                            } else {
                                $(this).siblings(".wizard-form-error").slideUp();
                            }
                        });
                        if (nextWizardStep) {
                            currentFieldset.removeClass("show", "400").addClass("hide", "400");
                            currentFieldset.next('.wizard-fieldset').removeClass("hide", "400").addClass("show", "400");
                        }
                        setProgressBar(++current);
                        if (currentFieldset.index() == 1) {
                            next.addClass('d-none');
                            $('.form-wizard-confirm-btn').removeClass('d-none');
                        }

                    });
                    //click on previous button
                    $('.form-wizard-previous-btn').click(function () {
                        let counter = parseInt($(".wizard-counter").text());
                        let prev = $(this);
                        let currentFieldset = prev.closest('.form-wizard').find('.wizard-fieldset.show');
                        console.log(currentFieldset.index())
                        if (currentFieldset.index() > 0) {
                            currentFieldset.removeClass("show", "400").addClass("hide", "400");
                            currentFieldset.prev('.wizard-fieldset').removeClass("hide", "400").addClass("show", "400");
                            setProgressBar(--current);
                            $('.form-wizard-next-btn').removeClass('d-none');
                            $('.form-wizard-confirm-btn').addClass('d-none');
                        }
                    });

                    {{--if ($("#upload_File").length != 0) {--}}
                    {{--    $("#upload_File").uploader({--}}
                    {{--        multiple: true,--}}
                    {{--        ajaxConfig: ajaxConfig,--}}
                    {{--        autoUpload: false,--}}
                    {{--        defaultValue: [--}}
                    {{--            {--}}
                    {{--                name: "image one",--}}
                    {{--                url: "{{ asset('frontend/assets/images/product-img.png') }}"--}}
                    {{--            }, {--}}
                    {{--                name: "image two",--}}
                    {{--                url: "assets/images/product-img2.png"--}}
                    {{--            }--}}
                    {{--        ],--}}

                    {{--    })--}}
                    {{--}--}}

                    {{--if ($("#upload_video").length != 0) {--}}
                    {{--    $("#upload_video").uploader({--}}
                    {{--        multiple: true,--}}
                    {{--        ajaxConfig: ajaxConfig,--}}
                    {{--        autoUpload: false,--}}
                    {{--        defaultValue: [--}}
                    {{--            {--}}
                    {{--                name: "image one",--}}
                    {{--                url: "assets/images/product-img.png"--}}
                    {{--            }--}}
                    {{--        ],--}}
                    {{--    })--}}
                    {{--}--}}

                    $('#priceType').change(function () {
                        if ($(this).val() == "open_offer") {
                            $("#info-price").val("");
                            $('#fixedPrice').addClass('d-none');
                            $('#offerPrice').removeClass('d-none');
                        } else {
                            $("#info-min-price").val("");
                            $("#info-max-price").val("");
                            $('#offerPrice').addClass('d-none');
                            $('#fixedPrice').removeClass('d-none');
                        }
                    })
                });


                $(document).ready(function () {
                    $('#nationalityId').change(function () {
                        var country_id = $(this).val();
                        if (country_id) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('states') }}" + "/" + country_id,
                                success: function (data) {
                                    $('#stateList').empty();
                                    $('#cityList').empty();
                                    $('#stateList').append('<option value="">{{ trans('web.Select State') }}</option>');
                                    $.each(data.data, function (key, value) {
                                        $('#stateList').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('#stateList').empty();
                            $('#cityList').empty();
                            $('#stateList').append('<option value="">{{ trans('web.Select State') }}</option>');
                        }
                    });

                    $('#stateList').change(function () {
                        var state_id = $(this).val();
                        if (state_id) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('cities') }}" + "/" + state_id,
                                success: function (data) {
                                    $('#cityList').empty();
                                    $('#cityList').append('<option value="">{{ trans('web.Select City') }}</option>');
                                    $.each(data.data, function (key, value) {
                                        $('#cityList').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('#cityList').empty();
                            $('#cityList').append('<option value="">{{ trans('web.Select City') }}</option>');
                        }
                    });
                });


                $(document).ready(function () {
                    // Function to create a new select element
                    function createSubCategorySelect(level) {
                        return `
                            <div class="col-lg-6 mb-3 sub-category-${level}">
                                <div class="sec-select">
                                    <select class="select2 w-100 form-control" name="sub_category_id_${level}" id="sub_category_id_${level}">
                                        <option value="">{{ trans('web.Select Sub Category') }}</option>
                                    </select>
                                </div>
                            </div>
                        `;
                    }

                    // Function to fetch and populate subcategories
                    function fetchSubCategories(parentId, level) {
                        $.ajax({
                            type: "GET",
                            url: `/categories/${parentId}/subcategories`,
                            success: function (data) {
                                if (data.length > 0) {
                                    // Append a new select for subcategories if subcategories exist
                                    const newSelect = createSubCategorySelect(level);
                                    $('#subCategorySelects').append(newSelect);

                                    // Populate the new select with subcategories
                                    $.each(data, function (index, subCategory) {
                                        $(`#sub_category_id_${level}`).append(`<option value="${subCategory.id}">${subCategory.name}</option>`);
                                    });

                                    // Attach change event to the new select
                                    $(`#sub_category_id_${level}`).change(function () {
                                        const selectedSubCategoryId = $(this).val();
                                        // Remove selects for deeper levels
                                        $(`.sub-category-${level + 1}`).remove();
                                        // Fetch subcategories for the selected subcategory
                                        if (selectedSubCategoryId) {
                                            fetchSubCategories(selectedSubCategoryId, level + 1);
                                        }
                                    });

                                    // Initialize select2 for the new select
                                    $(`#sub_category_id_${level}`).select2();
                                }
                            }
                        });
                    }

                    // Attach change event to the initial category select
                    $('#category_id').change(function () {
                        const categoryId = $(this).val();
                        // Remove all subcategory selects
                        $('#subCategorySelects').empty();
                        // Fetch subcategories for the selected category
                        if (categoryId) {
                            fetchSubCategories(categoryId, 1);
                        }
                    });

                    // Initialize select2 for the initial category select
                    $('#category_id').select2();
                });


                // start of script code of confirm modal
                // Trigger AJAX validation when the Confirm button is clicked
                $('#confirmFormBtn').click(function (e) {
                    e.preventDefault(); // Prevent the default form submission

                    var productType = $("input[name='type']:checked").val();

                    if (productType == 'free') {
                        validateAndSubmitForm();
                    } else if (productType == 'premium') {
                        // show confirm modal
                        $("#confirmModal").modal('show');
                    }
                });

                // Handle the confirm payment button in the modal
                $("#submitConfirmPay").click(function () {
                    validateAndSubmitForm();
                });

                // Function to validate and submit the form via AJAX
                function validateAndSubmitForm() {
                    let form = $('#addProductForm');
                    let url = form.attr('action'); // The form action URL
                    let formData = form.serialize(); // Serialize the form data

                    // Send an AJAX request to validate the form
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            clearErrors(); // Clear previous errors

                            // If validation is successful, submit the form
                            form.off('submit').submit();
                        },
                        error: function (xhr) {
                            let errors = xhr.responseJSON.errors;
                            clearErrors(); // Clear previous errors
                            displayErrors(errors); // Display the errors
                        }
                    });
                }

                // Function to clear previous errors
                function clearErrors() {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                }

                // Function to display errors under each field
                function displayErrors(errors) {
                    $.each(errors, function (key, errorMessages) {
                        let input = $('[name=' + key + ']');
                        input.addClass('is-invalid'); // Add Bootstrap's is-invalid class
                        let errorContainer = $('<div class="invalid-feedback"></div>'); // Create error message container
                        errorContainer.text(errorMessages[0]); // Set the error message
                        input.after(errorContainer); // Insert the error message after the input field
                    });
                }

                // Clear error messages when the user types or changes a selection
                $('#addProductForm').on('input change', 'input, select, textarea', function () {
                    $(this).removeClass('is-invalid'); // Remove the Bootstrap invalid class
                    $(this).next('.invalid-feedback').remove(); // Remove the error message
                });
                // end of script code of confirm modal


                $(document).ready(function() {
                    // Handle changes in the image upload input
                    $('input[name="images[]"]').on('change', function() {
                        var fileCount = this.files.length; // Get the number of files
                        $('#imageCount').text(fileCount); // Update the count display
                    });

                    // Handle changes in the video upload input
                    $('input[name="videos[]"]').on('change', function() {
                        var fileCount = this.files.length; // Get the number of files
                        $('#videoCount').text(fileCount); // Update the count display
                    });
                });


            </script>
@endsection
