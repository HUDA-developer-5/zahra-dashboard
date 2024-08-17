@extends('frontend.layouts.master')

@section("style")
    {{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ"></script>--}}
@endsection

@section('content')

{{--    <div id="main-wrapper">--}}

{{--        @includeIf('frontend.components.top_title', ['title' => trans('web.Products')])--}}

{{--        <div id="products" class="mb-5">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    @include('frontend.components.side_filters')--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">--}}
{{--                            <p class="text-gray fw-400 mb-0">{{ trans('web.Products') }}: {{ count($products) }}--}}
{{--                                ( {{ trans('web.search for') }} {{ $searchForCats }} ) </p>--}}
{{--                            <div class="d-flex gap-2">--}}
{{--                                <div class="sec-select">--}}
{{--                                    <select class="select2 w-100 form-control" id="SortBy">--}}
{{--                                        <option> {{ trans('web.Sort By') }}</option>--}}
{{--                                        <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}> {{ trans('web.Default') }}</option>--}}
{{--                                        <option value="high_price" {{ request('sort_by') == 'high_price' ? 'selected' : '' }}> {{ trans('web.Highest Price') }}</option>--}}
{{--                                        <option value="low_price" {{ request('sort_by') == 'low_price' ? 'selected' : '' }}> {{ trans('web.Lowest Price') }}</option>--}}
{{--                                        <option value="high_offer" {{ request('sort_by') == 'high_offer' ? 'selected' : '' }}> {{ trans('web.Highest Offer') }}</option>--}}
{{--                                        <option value="low_offer" {{ request('sort_by') == 'low_offer' ? 'selected' : '' }}> {{ trans('web.Lowest Offer') }}</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                @auth('users')--}}
{{--                                    <div>--}}
{{--                                        <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#mapModal"--}}
{{--                                           class="map"><i class="far fa-map"></i></a>--}}
{{--                                    </div>--}}
{{--                                @endauth--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="ads-list-sec">--}}
{{--                            <div class="row">--}}
{{--                                @if($products)--}}
{{--                                    @foreach($products as $product)--}}
{{--                                        <div class="col-xl-4 col-md-6 mb-3">--}}
{{--                                            @include('frontend.components.product_card', ['product' => $product])--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


<div id="main-wrapper">
    @includeIf('frontend.components.top_title', ['title' => trans('web.Products')])

    <div id="products" class="mb-5">
        <div class="container">
            <div class="row">
                @include('frontend.components.side_filters')
                <div class="col-lg-9">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                        <p class="text-gray fw-400 mb-0">{{ trans('web.Products') }}: {{ count($products) }}
                            ( {{ trans('web.search for') }} {{ $searchForCats }} ) </p>
                        <div class="d-flex gap-2">
                            <div class="sec-select">
                                <select class="select2 w-100 form-control" id="SortBy">
                                    <option> {{ trans('web.Sort By') }}</option>
                                    <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}> {{ trans('web.Default') }}</option>
                                    <option value="high_price" {{ request('sort_by') == 'high_price' ? 'selected' : '' }}> {{ trans('web.Highest Price') }}</option>
                                    <option value="low_price" {{ request('sort_by') == 'low_price' ? 'selected' : '' }}> {{ trans('web.Lowest Price') }}</option>
                                    <option value="high_offer" {{ request('sort_by') == 'high_offer' ? 'selected' : '' }}> {{ trans('web.Highest Offer') }}</option>
                                    <option value="low_offer" {{ request('sort_by') == 'low_offer' ? 'selected' : '' }}> {{ trans('web.Lowest Offer') }}</option>
                                </select>
                            </div>
                            @auth('users')
                                <div>
                                    <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#mapModal"
                                       class="map"><i class="far fa-map"></i></a>
                                </div>
                            @endauth
                        </div>
                    </div>
                    @include('frontend.render.product_list', ['products' => $products]) {{-- Include the product list --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section("script")


    <script>
        $(document).ready(function () {
            $('#filter-search').on('keypress', function (e) {
                if (e.which == 13) { // 13 is the Enter key code
                    e.preventDefault(); // Prevent the default form submission

                    var query = $(this).val();

                    $.ajax({
                        url: '{{ route('web.products.search') }}',
                        method: 'GET',
                        data: {
                            search: query,
                            filter: 'categories'
                        },
                        success: function (response) {
                            $('#category-list').html(response.html);
                        },
                        error: function (error) {
                            console.log("Error:", error);
                        }
                    });
                }
            });
        });
    </script>

<script>
    $(document).ready(function () {
        // Trigger filtering when categories are selected or deselected
        $('#category-list').on('change', 'input[name="categories_id[]"]', function () {
            fetchFilteredProducts();
        });

        // Trigger filtering when a country is selected
        $('select[name="country_id"]').on('change', function () {
            fetchFilteredProducts();
        });

        // Trigger filtering when the price range is changed
        $('input[name="price_from"], input[name="price_to"]').on('input', function () {
            fetchFilteredProducts();
        });

        // Function to update the hidden inputs and progress bar (if needed)
        function updateSlider() {
            let min = $('#rangeMin').val();
            let max = $('#rangeMax').val();
            $('#priceFrom').val(min);
            $('#priceTo').val(max);

            // Update the progress bar (optional)
            let progress = (min / 10000) * 100 + "%";
            $('.progress').css('left', progress);
        }

        // Trigger fetchFilteredProducts() only when the slider is released
        $('#rangeMin, #rangeMax').on('change', function () {
            updateSlider();
            fetchFilteredProducts();
        });


        // Handle click events on sec-check elements
        $('.sec-check').on('click', function () {
            // Toggle the checked state
            $(this).toggleClass('checked');

            // Find the hidden input and toggle its value
            var input = $(this).find('input[type="hidden"]');
            if ($(this).hasClass('checked')) {
                input.val("1"); // Check (set to 1)
            } else {
                input.val(""); // Uncheck (set to empty)
            }

            // Trigger the filtering
            fetchFilteredProducts();
        });


        // Handle change events on the SortBy select element
        $('#SortBy').on('change', function () {
            // Trigger the filtering when sorting option is changed
            fetchFilteredProducts();
        });


        function fetchFilteredProducts() {
            // var selectedCategories = [];
            // $('input[name="categories_id[]"]:checked').each(function () {
            //     selectedCategories.push($(this).val());
            // });

            var formData = $('#filterForm').serialize(); // Serialize all form dat
            var sortBy = $('#SortBy').val(); // Get the selected sort_by value

            // Manually add sort_by to the formData
            formData += '&sort_by=' + sortBy;

            $.ajax({
                url: '{{ route('web.products.search') }}',
                method: 'GET',
                data: formData,
                success: function (response) {
                    $('#products-list').html(response.html); // Update the product list
                },
                error: function (error) {
                    console.log("Error:", error);
                }
            });
        }
    });

</script>



{{--    <script>--}}
{{--        if (navigator.geolocation) {--}}
{{--            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);--}}
{{--        } else {--}}
{{--            console.log("Geolocation is not supported by this browser.");--}}
{{--        }--}}

{{--        function successCallback(position) {--}}
{{--            var latitude = position.coords.latitude;--}}
{{--            var longitude = position.coords.longitude;--}}

{{--            // set input values--}}
{{--            $('#latitude').val(latitude);--}}
{{--            $('#longitude').val(longitude);--}}
{{--            // Now you have the latitude and longitude, you can send them to your server if needed--}}
{{--            console.log("Latitude: " + latitude);--}}
{{--            console.log("Longitude: " + longitude);--}}
{{--        }--}}

{{--        function errorCallback(error) {--}}
{{--            switch (error.code) {--}}
{{--                case error.PERMISSION_DENIED:--}}
{{--                    console.log("User denied the request for Geolocation.");--}}
{{--                    break;--}}
{{--                case error.POSITION_UNAVAILABLE:--}}
{{--                    console.log("Location information is unavailable.");--}}
{{--                    break;--}}
{{--                case error.TIMEOUT:--}}
{{--                    console.log("The request to get user location timed out.");--}}
{{--                    break;--}}
{{--                case error.UNKNOWN_ERROR:--}}
{{--                    console.log("An unknown error occurred.");--}}
{{--                    break;--}}
{{--            }--}}
{{--        }--}}

{{--        $(document).ready(function () {--}}

{{--            $('.sec-check').click(function () {--}}
{{--                $(this).toggleClass('checked');--}}
{{--                var typeCheck = $(this).find('input[type="hidden"]')--}}
{{--                // set input value 1--}}
{{--                if (typeCheck.val() == "1") {--}}
{{--                    // set input value 0--}}
{{--                    typeCheck.val("");--}}
{{--                } else {--}}
{{--                    typeCheck.val("1");--}}
{{--                }--}}

{{--                // Submit the form--}}
{{--                $('#filterForm').submit();--}}
{{--            });--}}

{{--            // if #SortBy is change then submit the form--}}
{{--            $('#SortBy').on('change', function () {--}}
{{--                //set input value--}}
{{--                $('#SortByInput').val($(this).val());--}}
{{--                // Submit the form--}}
{{--                $('#filterForm').submit();--}}
{{--            })--}}
{{--            // Listen for changes in any input field inside the form--}}
{{--            // $('#filterForm :input').on('input', function () {--}}
{{--            //     // Submit the form when any input changes--}}
{{--            //     $('#filterForm').submit();--}}
{{--            // });--}}

{{--            var delayTimer;--}}

{{--            // Listen for changes in any input field inside the form--}}
{{--            $('#filterForm :input').on('input', function () {--}}
{{--                // Clear any previous delay timer--}}
{{--                clearTimeout(delayTimer);--}}

{{--                // Set a new delay timer--}}
{{--                delayTimer = setTimeout(function () {--}}
{{--                    // Submit the form after a delay of 2 seconds (2000 milliseconds)--}}
{{--                    $('#filterForm').submit();--}}
{{--                }, 2000); // Adjust the delay time (in milliseconds) as needed--}}
{{--            });--}}
{{--        });--}}

{{--        function initMap() {--}}
{{--            // Initialize the map--}}
{{--            var map = new google.maps.Map(document.getElementById('map'), {--}}
{{--                center: {lat: 30.033333, lng: 31.233334},--}}
{{--                zoom: 10 // Set the initial zoom level--}}
{{--            });--}}

{{--            @foreach($products as $product)--}}
{{--            @if($product->latitude && $product->longitude)--}}
{{--            var myLatLng = new google.maps.LatLng({{$product->latitude}}, {{$product->longitude}});--}}
{{--            new google.maps.Marker({--}}
{{--                position: myLatLng,--}}
{{--                map: map,--}}
{{--                title: "{{$product->default_price}}",--}}
{{--            });--}}
{{--            @endif--}}
{{--            @endforeach--}}
{{--        }--}}

{{--    </script>--}}

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ&callback=initMap"
            async defer></script>
@endsection
