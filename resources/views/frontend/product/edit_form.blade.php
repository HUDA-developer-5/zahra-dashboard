@extends('frontend.layouts.master')

@section("style")
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/ajax-file-uploader/css/jquery.uploader.css') }}">
@endsection

@section('content')
    <div id="main-wrapper">
        @includeIf('frontend.components.top_title', ['title' => trans('web.Edit your adds')])

        <div id="edit-ads">
            <div class="container">
                <div class="form-wizard">
                    @if ($errors->update_product->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->update_product->all() as $error)
                                    <li>-{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{ html()->modelForm($product, 'post', route('web.products.update', ['id' => $product->id]))->acceptsFiles()->open() }}
                    <div class="card mb-3">
                        <h5 class="fw-bold mb-4">{{ trans('web.Edit Photo') }}</h5>
                        <fieldset class="wizard-fieldset add_info">
                            <div id="pro_images" class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product image') }}</h6>
                                    <p> (<span class="text-secondary">1</span>)</p>
                                </div>
                                <div>
                                    <input name="image" type="file" value="">
                                </div>
                            </div>

                            <div id="pro_images" class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product images') }}</h6>
                                    <p> (<span class="text-secondary">0</span>/20)</p>
                                </div>
                                <div>
                                    <input name="images[]" type="file" id="upload_File" value="" multiple>
                                </div>
                            </div>
                            <div id="pro_videos" class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="flex-grow-1">{{ trans('web.Product Video') }} <span class="text-gray">( {{ trans('web.optional') }} )</span>
                                    </h6>
                                    <p> (<span class="text-secondary">0</span>/20)</p>
                                </div>
                                <div>
                                    <input name="videos[]" type="file" id="upload_video" value="" multiple>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card mb-3">
                        <fieldset class="wizard-fieldset add_info_2">
                            <div class="title">
                                <h5 class="fw-bold  mb-3">{{ trans('web.Edit Info') }}</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    @if($menuCategories)
                                        <div class="sec-select">
                                            {{ html()->select()->name('category_id')->options($menuCategories->pluck('name', 'id'))->class('select2 w-100 form-control') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        {{ html()->text('name')->placeholder(trans('web.Title'))->class('form-control')->id('info-title') }}
                                        <label class="form-label" for="info-title">{{ trans('web.Title') }}</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-input">
                                        {{ html()->textarea('name')->placeholder(trans('web.Description'))->class('form-control')->rows(5)->maxlength(1024)->id('info-desc') }}
                                        <label class="form-label" for="info-desc">{{ trans('web.Description') }}</label>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    {{ html()->select('price_type', $price_types, $product->price_type)->id('priceType')->class('form-select price-type form-control') }}
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="price" id="fixedPrice">
                                        <div class="form-input">
                                            {{ html()->number('price')->placeholder(trans('web.Price'))->id('info-price')->class('form-control input-with-currency') }}

                                            <label class="form-label" for="info-price">{{ trans('web.Price') }}</label>
                                        </div>
                                        <div class="currency">
                                            {{ html()->select('currency', $countries->pluck('currency', 'currency'))->class('form-select') }}
                                        </div>
                                    </div>
                                    <div class="d-none" id="offerPrice">
                                        <div class="d-flex gap-3">
                                            <div class="w-50">
                                                <div class="form-input">
                                                    {{ html()->number('min_price')->placeholder(trans('web.Min Price'))->id('info-min-price')->class('form-control') }}

                                                    <label class="form-label"
                                                           for="info-min-price">{{  trans('web.Min Price') }}</label>
                                                </div>
                                            </div>
                                            <div class="price w-50">
                                                <div class="form-input">
                                                    {{ html()->number('max_price')->placeholder(trans('web.Max Price'))->id('info-max-price')->class('form-control input-with-currency') }}
                                                    <label class="form-label"
                                                           for="info-max-price">{{  trans('web.Max Price') }}</label>
                                                </div>
                                                <div class="currency">
                                                    {{ html()->select('currency', $countries->pluck('currency', 'currency'))->id("offerCurrency")->class('form-select') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        {{ html()->text('phone_number')->id('info-phone')->class('form-control')->placeholder(trans('web.Phone number')) }}
                                        <label class="form-label"
                                               for="info-phone">{{ trans('web.Phone number') }}</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-input">
                                        {{ html()->text('whatsapp_number')->id('info-whatapp-num')->class('form-control')->placeholder(trans('web.Whatsapp number')) }}

                                        <label class="form-label"
                                               for="info-whatapp-num">{{ trans('web.Whatsapp number') }}</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-check form-switch">
                                        <input name="is_sold" class="form-check-input" type="checkbox" value="1"
                                               id="activeChecked" @if($product->is_sold) checked @endif>
                                        {{ html()->label(trans('web.Is Sold'))->class('form-check-label')->for('activeChecked') }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card mb-3">
                        <fieldset class="wizard-fieldset add_address_info">
                            <div class="title">
                                <h5>{{ trans('web.Add Address Info') }}</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    {{ html()->select('nationality_id', $countries->pluck('name', 'id'))->id('nationalityId')->class('select2 w-100 form-control"') }}
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select class="select2 w-100 form-control" name="state_id" id="stateList"
                                            value="{{ old('state_id') }}">
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select class="select2 w-100 form-control" name="city_id" id="cityList"
                                            value="{{ old('city_id') }}">
                                    </select>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div id="map"></div>
                                    <input type="hidden" name="latitude" id="latitude" value="{{ $product->latitude }}">
                                    <input type="hidden" name="longitude" id="longitude"
                                           value="{{ $product->longitude }}">
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label" for="normalAd">
                                            {{ trans('web.Normal ad') }}
                                        </label>

                                        {{ html()->radio('type', null, 'free')->class('form-check-input')->id('normalAd') }}
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="d-flex justify-content-between check-form">
                                        <label class="form-check-label" for="premiumAd">
                                            <img src="{{ asset('frontend/assets/images/icons/crown.svg') }}"
                                                 alt="crown icon">
                                            <span>{{ trans('web.Premium') }}</span>
                                        </label>
                                        {{ html()->radio('type', null, 'premium')->class('form-check-input')->id('premiumAd') }}

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-end">
                            <button type="submit"
                                    class="btn btn-gradiant btn-update px-5 py-2">{{ trans('web.Update') }}</button>
                        </div>
                    </div>
                    {{ html()->closeModelForm() }}
                </div>
            </div>
        </div>

        @stop

        @section("script")
            <script src="{{ asset('frontend/assets/js/map.js') }}"></script>
            <script src="{{ asset('frontend/assets/plugins/ajax-file-uploader/dist/jquery.uploader.min.js') }}"></script>
            <script>
                $(document).ready(function () {

                    $('#priceType').change(function () {
                        changeProductPriceType($(this).val());
                    })

                    changeProductPriceType("{{ $product->price_type }}");

                    function changeProductPriceType(type) {
                        if (type == "open_offer") {
                            $("#info-price").val("");
                            $('#fixedPrice').addClass('d-none');
                            $('#offerPrice').removeClass('d-none');
                        } else {
                            $("#info-min-price").val("");
                            $("#info-max-price").val("");
                            $('#offerPrice').addClass('d-none');
                            $('#fixedPrice').removeClass('d-none');
                        }
                    }

                    function getStates(country_id) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('states') }}" + "/" + country_id,
                            success: function (data) {
                                $('#stateList').empty();
                                $('#cityList').empty();
                                $('#stateList').append('<option value="">{{ trans('web.Select State') }}</option>');
                                var selected_state = {{ $product->state_id }};

                                $.each(data.data, function (key, value) {
                                    var selected = (value.id == selected_state) ? "selected" : "";
                                    $('#stateList').append(`<option ${selected} value="` + value.id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    }

                    function getCities(state_id) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('cities') }}" + "/" + state_id,
                            success: function (data) {
                                $('#cityList').empty();
                                $('#cityList').append('<option value="">{{ trans('web.Select City') }}</option>');
                                var selected_city = {{ $product->city_id }};
                                $.each(data.data, function (key, value) {
                                    var is_selected = (value.id == selected_city) ? "selected" : "";
                                    $('#cityList').append(`<option ${is_selected} value="` + value.id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    }

                    getStates({{ $product->nationality_id }})
                    getCities({{ $product->state_id }})

                    $('#nationalityId').change(function () {
                        var country_id = $(this).val();
                        if (country_id) {
                            getStates(country_id)
                        } else {
                            $('#stateList').empty();
                            $('#cityList').empty();
                            $('#stateList').append('<option value="">{{ trans('web.Select State') }}</option>');
                        }
                    });

                    $('#stateList').change(function () {
                        var state_id = $(this).val();
                        if (state_id) {
                            getCities(state_id)
                        } else {
                            $('#cityList').empty();
                            $('#cityList').append('<option value="">{{ trans('web.Select City') }}</option>');
                        }
                    });
                });
            </script>
@endsection
