@extends('frontend.layouts.master')

@section("style")
{{--    <style>--}}
{{--        .owl-item.active {--}}
{{--            width: 100px !important;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('content')

    <div id="main-wrapper">

        <div id="categories" class="py-4">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="title fw-bold">{{ trans('web.Categories') }}</h2>
                    <div class="d-lg-none d-block">
                        <a href="{{ route('web.categories') }}" class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                </div>
                <div class="categories-list">
{{--                    <div class="owl-carousel categories-carousel">--}}
{{--                        @forelse($parentCategories as $parentCategory)--}}
{{--                            <div class="item">--}}
{{--                                <div class="category text-center {{ ($parent_cat_id == $parentCategory->id) ? 'active' : '' }}">--}}
{{--                                    <div class="img mb-2">--}}
{{--                                        <a href="{{ route('web.home', ['parent_cat_id' => $parentCategory->id]) }}">--}}
{{--                                            <img src="{{ $parentCategory->image_path }}" alt="{{ $parentCategory->name }}" class="img-fluid" loading="lazy">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <h6 class="name">{{ $parentCategory->name }}</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @empty--}}
{{--                            <p>{{ trans('web.No Categories Available') }}</p>--}}
{{--                        @endforelse--}}
{{--                    </div>--}}
{{--                    <div class="sub-category">--}}
{{--                        <div class="owl-carousel sub-category-carousel">--}}
{{--                            @forelse($subCategories as $subCategory)--}}
{{--                                <div class="item">--}}
{{--                                    <div class="category text-center">--}}
{{--                                        <div class="img mb-2">--}}
{{--                                            <img src="{{ $subCategory->image_path }}" alt="{{ $subCategory->name }}" class="img-fluid" loading="lazy">--}}
{{--                                        </div>--}}
{{--                                        <h6 class="name">{{ $subCategory->name }}</h6>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @empty--}}
{{--                                <p>{{ trans('web.No Subcategories Available') }}</p>--}}
{{--                            @endforelse--}}
{{--                        </div>--}}
{{--                    </div>--}}



                    <div class="owl-carousel categories-carousel">
                        @forelse($parentCategories as $index => $parentCategory)
                            <div class="item">
                                <div class="category text-center parent-category {{ $index == 0 ? 'active' : '' }}" data-id="{{ $parentCategory->id }}">
                                    <div class="img mb-2">
                                        <a href="#" class="parent-category-link">
                                            <img src="{{ $parentCategory->image_path }}" alt="{{ $parentCategory->name }}" class="img-fluid" loading="lazy">
                                        </a>
                                    </div>
                                    <h6 class="name">{{ $parentCategory->name }}</h6>
                                </div>
                            </div>
                        @empty
                            <p>{{ trans('web.No Categories Available') }}</p>
                        @endforelse
                    </div>
                    <div class="sub-category">
                        <div class="owl-carousel sub-category-carousel" id="sub-category-carousel">
                            <!-- Subcategories will be loaded here dynamically -->
                        </div>
                    </div>




                    <div class="text-center mt-4 d-none d-lg-block">
                        <a href="{{ route('web.categories') }}" class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="featured-ads" class="z-ads-section py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">{{ trans('web.Featured') }}</h5>
                    @includeIf('frontend.components.filter_card', ['parentCategories' => $parentCategories, 'mapId' => 'featureMapModal', 'type' => 'featured'])
                </div>
{{--                @if($featured->count())--}}
                    <div class="ads-list-sec">
                        <div class="row" id="featured_ads"></div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('web.products.search', ['is_featured' => 1]) }}" class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
{{--                @endif--}}
            </div>
        </div>

        @if($banner)
            <div id="profile-sec" class="py-4">
                <div class="container">
                    <div class="build-profile">
                        <div class="row align-items-center">
                            <div class="col-md-6 order-2 order-md-1 text-md-end text-center">
                                <div class="img">
                                    <img src="{{ $banner->image_path }}" alt="{{ $banner->name }}" loading="lazy">
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
{{--                @if($latest->count())--}}
                    <div class="ads-list-sec">
                        <div class="row" id="latest_ads"></div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('web.products.search') }}" class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
{{--                @endif--}}
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

        // $(document).ready(function () {
        //
        //     $('.sec-check').click(function () {
        //         $(this).toggleClass('checked');
        //         var typeCheck = $(this).find('input[type="hidden"]')
        //         // set input value 1
        //         if (typeCheck.val() == "1") {
        //             // set input value 0
        //             typeCheck.val("");
        //         } else {
        //             typeCheck.val("1");
        //         }
        //
        //         // Submit the form
        //         $('.filterForm').submit();
        //     });
        //     // Listen for changes in any input field inside the form
        //     // $('#filterForm :input').on('input', function () {
        //     //     // Submit the form when any input changes
        //     //     $('#filterForm').submit();
        //     // });
        //
        //     var delayTimer;
        //
        //     // Listen for changes in any input field inside the form
        //     $('.filterForm :input').on('input', function () {
        //         // Clear any previous delay timer
        //         clearTimeout(delayTimer);
        //
        //         // Set a new delay timer
        //         delayTimer = setTimeout(function () {
        //             // Submit the form after a delay of 2 seconds (2000 milliseconds)
        //             $('.filterForm').submit();
        //         }, 2000); // Adjust the delay time (in milliseconds) as needed
        //     });
        // });

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

{{--            @if($featured->count())--}}
{{--            @foreach($featured as $product)--}}
{{--            @if($product->latitude && $product->longitude)--}}
{{--            var featureLatLng = new google.maps.LatLng({{$product->latitude}}, {{$product->longitude}});--}}
{{--            new google.maps.Marker({--}}
{{--                position: featureLatLng,--}}
{{--                map: mapFeature,--}}
{{--                title: "{{$product->default_price}}",--}}
{{--            });--}}
{{--            @endif--}}
{{--            @endforeach--}}
{{--            @endif--}}

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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const featuredAds = document.getElementById('featured_ads');
            const latestAds = document.getElementById('latest_ads');

            const routes = {
                featured: "{{ route('web.get_featured_ads') }}",
                latest: "{{ route('web.get_latest_ads') }}"
            };

            function filterAds(type, container) {
                let categoryElement = document.querySelector(`.category_id_${type}`);
                let category_id = categoryElement ? categoryElement.value : null;

                let subCategoryElements = document.querySelector(`.sub_category_id_${type}_1`);
                let sub_category_id_1 = subCategoryElements ? subCategoryElements.value : null;

                let subCategoryElements2 = document.querySelector(`.sub_category_id_${type}_2`);
                let sub_category_id_2 = subCategoryElements2 ? subCategoryElements2.value : null;

                let subCategoryElements3 = document.querySelector(`.sub_category_id_${type}_3`);
                let sub_category_id_3 = subCategoryElements3 ? subCategoryElements3.value : null;

                let countryElement = document.querySelector(`.country_id_${type}`);
                let country_id = countryElement ? countryElement.value : null;

                let mostViewedElement = document.querySelector(`.most-viewed-${type} input`);
                let most_viewed = mostViewedElement ? mostViewedElement.value : null;

                const filter = {
                    category_id: category_id,
                    country_id: country_id,
                    sub_category_id_1: sub_category_id_1,
                    sub_category_id_2: sub_category_id_2,
                    sub_category_id_3: sub_category_id_3,
                    most_viewed: most_viewed
                };

                const queryString = new URLSearchParams(filter).toString();

                const url = routes[type] + '?' + queryString;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = '';
                        container.insertAdjacentHTML('beforeend', data[`${type}AdsHtml`]);
                    })
                    .catch(error => {
                        console.error('Error fetching ads:', error);
                    });
            }

            function initSelects(type) {
                function createSubCategorySelect(level) {
                    return `
                    <div class="sec-select sub-category-${type}-${level}">
                        <select class="select2 w-100 form-control sub_category_id_${type}_${level}" name="sub_category_id_${level}">
                            <option selected disabled>{{ trans('web.select_Sub_Category') }}</option>
                        </select>
                    </div>
                `;
                }

                function fetchSubCategories(parentId, level) {
                    $.ajax({
                        type: "GET",
                        url: `/categories/${parentId}/subcategories`,
                        success: function (data) {
                            if (data.length > 0) {
                                const newSelect = createSubCategorySelect(level);
                                $(`.subCategorySelects_${type}`).append(newSelect);

                                $.each(data, function (index, subCategory) {
                                    $(`.sub_category_id_${type}_${level}`).append(`<option value="${subCategory.id}">${subCategory.name}</option>`);
                                });

                                $(`.sub_category_id_${type}_${level}`).change(function () {
                                    const selectedSubCategoryId = $(this).val();
                                    $(`.sub-category-${type}-${level + 1}`).remove();
                                    if (selectedSubCategoryId) {
                                        fetchSubCategories(selectedSubCategoryId, level + 1);
                                        filterAds(type, type === 'featured' ? featuredAds : latestAds);
                                    }
                                });

                                $(`.sub_category_id_${type}_${level}`).select2();
                            }
                        }
                    });
                }

                $(`.country_id_${type}`).change(function () {
                    filterAds(type, type === 'featured' ? featuredAds : latestAds);
                });

                $(`.category_id_${type}`).change(function () {
                    const categoryId = $(this).val();
                    $(`.subCategorySelects_${type}`).empty();
                    if (categoryId) {
                        fetchSubCategories(categoryId, 1);
                        filterAds(type, type === 'featured' ? featuredAds : latestAds);
                    }
                });

                $(`.category_id_${type}`).select2();

            }

            filterAds('featured', featuredAds);
            filterAds('latest', latestAds);
            initSelects('featured');
            initSelects('latest');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fetchSubCategories(parentId) {
                $.ajax({
                    type: "GET",
                    url: `/categories/${parentId}/subcategoriesUsingView`,
                    success: function (data) {
                        console.log("Data received:", data);
                        const subCategoryCarousel = $('#sub-category-carousel');
                        subCategoryCarousel.trigger('destroy.owl.carousel'); // Destroy the current instance
                        subCategoryCarousel.empty(); // Clear the carousel
                        subCategoryCarousel.append(data['subcategoriesHtml']); // Append the new items
                        subCategoryCarousel.owlCarousel({
                            // reinitialize carousel with settings
                            loop: true,
                            margin: 10,
                            width: 100,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 3
                                },
                                1000: {
                                    items: 5
                                }
                            },
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching subcategories:', error);
                    }
                });
            }

            function selectFirstParentCategory() {
                const firstParentCategory = $('.parent-category').first();
                const parentId = firstParentCategory.data('id');
                firstParentCategory.addClass('active');
                fetchSubCategories(parentId);
            }

            $(document).on('click', '.parent-category-link', function (e) {
                e.preventDefault();
                $('.parent-category').removeClass('active');
                const parentCategory = $(this).closest('.parent-category');
                parentCategory.addClass('active');
                const parentId = parentCategory.data('id');
                fetchSubCategories(parentId);
            });

            selectFirstParentCategory();
            // Initialize the Owl Carousels
            $('.categories-carousel').owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
    </script>
@endsection
