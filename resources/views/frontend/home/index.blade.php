@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')

    <div id="main-wrapper">

{{--        <livewire:category />--}}
        <div id="categories" class="py-4">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="title fw-bold">{{ trans('web.Categories') }}</h2>
                    <div class="d-lg-none d-block">
                        <a href="{{ route('web.categories') }}"
                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                </div>
                <div class="categories-list">
                    <div class="owl-carousel categories-carousel">
                        @if($parentCategories->count())
                            @foreach($parentCategories as $parentCategory)
                                <div class="item">
                                    <div class="category text-center {{ ($parent_cat_id == $parentCategory->id) ? "active" : "" }}">
                                        <div class="img mb-2">
                                            <a href="{{ route('web.home').'?parent_cat_id='.$parentCategory->id }}">
                                                <img src="{{ $parentCategory->image_path }}"
                                                     alt="{{ $parentCategory->name }}" class="img-fluid" loading="lazy">
                                            </a>
                                        </div>
                                        <h6 class="name">{{ $parentCategory->name }}</h6>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="sub-category">
                        <div class="owl-carousel sub-category-carousel">
                            @if($subCategories->count())
                                @foreach($subCategories as $subCategory)
                                    <div class="item">
                                        <div class="category text-center">
                                            <div class="img mb-2">
                                                <img src="{{ $subCategory->image_path }}" alt="{{ $subCategory->name }}"
                                                     class="img-fluid"
                                                     loading="lazy">
                                            </div>
                                            <h6 class="name">{{ $subCategory->name }}</h6>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-center mt-4 d-none d-lg-block">
                        <a href="{{ route('web.categories') }}"
                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="featured-ads" class="z-ads-section py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">{{ trans('web.Featured') }}</h5>
                    @includeIf('frontend.components.filter_card', ['parentCategories' => $parentCategories, 'mapId' => 'featureMapModal',  'type' => 'featured'])
                </div>
                @if($featured->count())
                    <div class="ads-list-sec">
                        <div class="row">
                            @foreach($featured as $featuredItem)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                                    @includeIf('frontend.components.product_card', ['product' => $featuredItem])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('web.products.search', ['is_featured' => 1]) }}"
                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                @endif
            </div>
        </div>

        @if($banner)
            <div id="profile-sec" class="py-4">
                <div class="container">
                    <div class="build-profile">
                        <div class="row align-items-center">
                            <div class="col-md-6 order-2 order-md-1 text-md-end text-center">
                                <div class="img">
                                    <img src="{{ $banner->image_path }}" alt="{{ $banner->name }}"
                                         loading="lazy">
                                </div>
                            </div>
                            <div class="offset-xl-1 col-xl-5 col-md-6 order-1 order-md-2">
                                <div class="content-txt">
                                    <h5 class="title fw-bold mb-2">{{ $banner->name }}</h5>
                                    <p class="desc mb-3">{{ $banner->description }}</p>
                                    <a href="{{ $banner->link }}" target="_blank" class="btn btn-gradiant fw-bold">{{ trans('web.Create') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div id="latest-ads" class="z-ads-section py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">{{ trans('web.Latest') }}</h5>
                    @includeIf('frontend.components.filter_card', ['parentCategories' => $parentCategories, 'mapId' => 'mapModalLatest', 'type' => 'latest'])
                </div>
                @if($latest->count())
                    <div class="ads-list-sec">
                        <div class="row">
                            @foreach($latest as $latestAd)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                                    @includeIf('frontend.components.product_card', ['product' => $latestAd])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('web.products.search') }}"
                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
@stop

@section("script")
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

        function successCallback(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // set input values
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            // Now you have the latitude and longitude, you can send them to your server if needed
            console.log("Latitude: " + latitude);
            console.log("Longitude: " + longitude);
        }

        function errorCallback(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }

        $(document).ready(function () {

            $('.sec-check').click(function () {
                $(this).toggleClass('checked');
                var typeCheck = $(this).find('input[type="hidden"]')
                // set input value 1
                if (typeCheck.val() == "1") {
                    // set input value 0
                    typeCheck.val("");
                } else {
                    typeCheck.val("1");
                }

                // Submit the form
                $('.filterForm').submit();
            });
            // Listen for changes in any input field inside the form
            // $('#filterForm :input').on('input', function () {
            //     // Submit the form when any input changes
            //     $('#filterForm').submit();
            // });

            var delayTimer;

            // Listen for changes in any input field inside the form
            $('.filterForm :input').on('input', function () {
                // Clear any previous delay timer
                clearTimeout(delayTimer);

                // Set a new delay timer
                delayTimer = setTimeout(function () {
                    // Submit the form after a delay of 2 seconds (2000 milliseconds)
                    $('.filterForm').submit();
                }, 2000); // Adjust the delay time (in milliseconds) as needed
            });
        });

        function initMap() {
            // Initialize the map
            var mapFeature = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 30.033333, lng: 31.233334},
                zoom: 10 // Set the initial zoom level
            });

            // var mapLatest = new google.maps.Map(document.getElementById('mapLatest'), {
            //     center: {lat: 30.033333, lng: 31.233334},
            //     zoom: 10 // Set the initial zoom level
            // });

            @if($featured->count())
            @foreach($featured as $product)
            @if($product->latitude && $product->longitude)
            var featureLatLng = new google.maps.LatLng({{$product->latitude}}, {{$product->longitude}});
            new google.maps.Marker({
                position: featureLatLng,
                map: mapFeature,
                title: "{{$product->default_price}}",
            });
            @endif
            @endforeach
            @endif

            {{--            @if($latest->count())--}}
            {{--            @foreach($latest as $product)--}}
            {{--            @if($product->latitude && $product->longitude)--}}
            {{--            var latestLatLng = new google.maps.LatLng({{$product->latitude}}, {{$product->longitude}});--}}
            {{--            new google.maps.Marker({--}}
            {{--                position: latestLatLng,--}}
            {{--                map: mapLatest,--}}
            {{--                title: "{{$product->default_price}}",--}}
            {{--            });--}}
            {{--            @endif--}}
            {{--            @endforeach--}}
            {{--            @endif--}}
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ&callback=initMap"
            async defer></script>
@endsection
