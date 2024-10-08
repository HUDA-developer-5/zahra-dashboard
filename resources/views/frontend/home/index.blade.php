@extends('frontend.layouts.master')

@section("style")
        <style>
            /*.owl-item.active {*/
            /*    width: 100px !important;*/
            /*}*/
            .custom-marker-label {
                background-color: #efecec; /* Red background */
                padding: 5px 10px; /* Padding to make it a box */
                border-radius: 3px; /* Rounded corners */
                font-size: 12px; /* Font size */
                border: 1px solid #000000; /* Optional: Border for the box */
                box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Optional: Add shadow for 3D effect */
            }

        </style>
@endsection

@section('content')

    <div id="main-wrapper">

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
                                <div class="category text-center parent-category {{ $index == 0 ? 'active' : '' }}"
                                     data-id="{{ $parentCategory->id }}">
                                    <div class="img mb-2">
                                        <a href="#" class="parent-category-link">
                                            <img src="{{ $parentCategory->image_path }}"
                                                 alt="{{ $parentCategory->name }}" class="img-fluid" loading="lazy">
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
                        <a href="{{ route('web.categories') }}"
                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Ads Section -->
        <div id="featured-ads" class="z-ads-section py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">{{ trans('web.Featured') }}</h5>
                    @includeIf('frontend.components.filter_card', ['parentCategories' => $parentCategories, 'mapId' => 'featureMapModal', 'type' => 'featured'])
                </div>
                <div class="ads-list-sec">
                    <div class="row" id="featured_ads"></div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('web.products.search', ['is_featured' => 1]) }}"
                       class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                </div>

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
                                    <a href="{{ $banner->link }}" target="_blank"
                                       class="btn btn-gradiant fw-bold">{{ trans('web.Create') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Latest Ads Section -->
        <div id="latest-ads" class="z-ads-section py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">{{ trans('web.Latest') }}</h5>
                    @includeIf('frontend.components.filter_card', ['parentCategories' => $parentCategories, 'mapId' => 'mapModalLatest', 'type' => 'latest'])
                </div>
                <div class="ads-list-sec">
                    <div class="row" id="latest_ads"></div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('web.products.search') }}"
                       class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                </div>

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

        // function initMap() {
        //     // Initialize the map
        //     var mapFeature = new google.maps.Map(document.getElementById('map'), {
        //         center: {lat: 30.033333, lng: 31.233334},
        //         zoom: 10 // Set the initial zoom level
        //     });

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
        // }


    </script>

    <script>
        let featuredMap, latestMap;
        let featuredMarkers = [];
        let latestMarkers = [];

        function initMap() {
            // Initialize the featured ads map
            featuredMap = new google.maps.Map(document.getElementById('mapFeature'), {
                center: { lat: 30.033333, lng: 31.233334 }, // Default center
                zoom: 10
            });

            // Initialize the latest ads map
            latestMap = new google.maps.Map(document.getElementById('mapLatest'), {
                center: { lat: 30.033333, lng: 31.233334 }, // Default center
                zoom: 10
            });
        }

        // Clear all markers from the map
        function clearMarkers(markersArray) {
            for (let marker of markersArray) {
                marker.setMap(null);
            }
            markersArray = [];
        }

        // Add markers for ads on the map
        function addMarkersForAds(map, adsData, markersArray) {
            clearMarkers(markersArray);
            adsData.forEach(function (ad) {
                if (ad.latitude && ad.longitude && !isNaN(ad.latitude) && !isNaN(ad.longitude)) {
                    console.log('ad latitude:', ad.latitude, 'longitude:', ad.longitude);
                    let marker = new google.maps.Marker({
                        position: { lat: +ad.latitude, lng: +ad.longitude },
                        map: map,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE, // You can use custom SVG or other shapes too
                            scale: 0, // No default marker
                        },
                        label: {
                            text: `$${ad.price}`, // Display price as label
                            color: '#c70707', // White text color
                            fontWeight: 'bold',
                            className: 'custom-marker-label' // CSS class for custom styling
                        }
                    });


                    markersArray.push(marker);
                } else {
                    console.warn('Invalid latitude or longitude for ad:', ad);
                }
            });
        }

        // Fetch and render featured ads with map markers
        function fetchFeaturedAds() {
            fetch("{{ route('web.get_featured_ads') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('featured_ads').innerHTML = data.featuredAdsHtml;
                    addMarkersForAds(featuredMap, data.adsForMap, featuredMarkers);
                })
                .catch(error => console.error('Error fetching featured ads:', error));
        }

        // Fetch and render latest ads with map markers
        function fetchLatestAds() {
            fetch("{{ route('web.get_latest_ads') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('latest_ads').innerHTML = data.latestAdsHtml;
                    addMarkersForAds(latestMap, data.adsForMap, latestMarkers);
                })
                .catch(error => console.error('Error fetching latest ads:', error));
        }

        // Initialize maps and fetch ads when the page is ready
        document.addEventListener('DOMContentLoaded', function () {
            initMap(); // Initialize maps
            // fetchFeaturedAds(); // Fetch featured ads and populate map
            // fetchLatestAds(); // Fetch latest ads and populate map
        });

        // When the modal is shown, trigger the resize event to make sure the maps are properly displayed
        $('#featureMapModal').on('shown.bs.modal', function () {
            google.maps.event.trigger(featuredMap, 'resize');
        });

        $('#mapModalLatest').on('shown.bs.modal', function () {
            google.maps.event.trigger(latestMap, 'resize');
        });
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

                let mostViewedElement = document.querySelector(`.most_viewed_${type} input[name="most_viewed"]`);
                let most_viewed = mostViewedElement ? mostViewedElement.value : null;

                let availablePhotoElement = document.querySelector(`.available_photo_${type} input[name="available_photo"]`);
                let available_photo = availablePhotoElement ? availablePhotoElement.value : null;

                let createdAtElement = document.querySelector(`#created_at_select_${type}`);
                let created_at = createdAtElement ? createdAtElement.value : null;

                const stateElement = document.querySelector(`.state_id_${type}`);
                const state_id = stateElement ? stateElement.value : null;

                const cityElement = document.querySelector(`.city_id_${type}`);
                const city_id = cityElement ? cityElement.value : null;


                const filter = {
                    category_id: category_id,
                    // country_id: country_id,
                    sub_category_id_1: sub_category_id_1,
                    sub_category_id_2: sub_category_id_2,
                    sub_category_id_3: sub_category_id_3,
                    most_viewed: most_viewed, // Add most_viewed to the filter,
                    available_photo: available_photo,
                    created_at: created_at,
                    state_id: state_id,
                    city_id: city_id

                };

                const queryString = new URLSearchParams(filter).toString();

                const url = routes[type] + '?' + queryString;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = '';
                        container.insertAdjacentHTML('beforeend', data[`${type}AdsHtml`]);
                        // Check the type and execute the corresponding addMarkersForAds function
                        if (type === 'featured') {
                            addMarkersForAds(featuredMap, data.adsForMap, featuredMarkers);
                        } else if (type === 'latest') {
                            addMarkersForAds(latestMap, data.adsForMap, latestMarkers);
                        }
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
                            url: ` /categories/${parentId}/subcategories`,
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
                        }
                    )
                    ;
                }

                // Event listeners for select and checkbox changes
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

                // // Event listener for "Near by", "Available photo", and "Most viewed" checkboxes
                // $(`.sec-check input`).change(function () {
                //     filterAds(type, type === 'featured' ? featuredAds : latestAds);
                // });

                // Select the div with the most_viewed class specific to the type
                {{--const type = @json($type); // Convert PHP variable to JavaScript--}}

                const mostViewedDiv = document.querySelector(`.most_viewed_${type}`);

                if (mostViewedDiv) {
                    // Add a click event listener
                    mostViewedDiv.addEventListener('click', function () {
                        const hiddenInput = mostViewedDiv.querySelector('input[name="most_viewed"]');

                        console.log('Most Viewed clicked!'); // Debug log

                        if (hiddenInput.value === "1") {
                            // If already checked, uncheck it
                            hiddenInput.value = ''; // Clear the hidden input value
                            mostViewedDiv.classList.add('checked');
                            console.log('Unchecked: ', hiddenInput.value); // Debug log
                        } else {
                            // If not checked, check it and set the value to true
                            hiddenInput.value = '1'; // Set value to '1'
                            mostViewedDiv.classList.remove('checked');
                            console.log('Checked: ', hiddenInput.value); // Debug log
                        }

                        // Trigger the filterAds function after the value changes
                        filterAds(type, type === 'featured' ? featuredAds : latestAds);
                    });
                }


                const availablePhotoDiv = document.querySelector(`.available_photo_${type}`);

                if (availablePhotoDiv) {
                    // Add a click event listener
                    availablePhotoDiv.addEventListener('click', function () {
                        const hiddenInput = availablePhotoDiv.querySelector('input[name="available_photo"]');

                        console.log('Most Viewed clicked!'); // Debug log

                        if (hiddenInput.value === "1") {
                            // If already checked, uncheck it
                            hiddenInput.value = ''; // Clear the hidden input value
                            availablePhotoDiv.classList.add('checked');
                            console.log('Unchecked: ', hiddenInput.value); // Debug log
                        } else {
                            // If not checked, check it and set the value to true
                            hiddenInput.value = '1'; // Set value to '1'
                            availablePhotoDiv.classList.remove('checked');
                            console.log('Checked: ', hiddenInput.value); // Debug log
                        }

                        // Trigger the filterAds function after the value changes
                        filterAds(type, type === 'featured' ? featuredAds : latestAds);
                    });
                }

                // Event listener for created_at select change
                $(`#created_at_select_${type}`).change(function () {
                    filterAds(type, type === 'featured' ? featuredAds : latestAds);
                });


                // Event listener for state_id select change
                $(`.state_id_${type}`).on('change', function () {
                    var stateId = $(this).val();
                    console.log('State ID:', stateId);
                    var citySelect = $(`.city_id_${type}`);

                    // Clear the existing options in the city dropdown
                    citySelect.empty().append('<option label="{{ trans('web.City') }}"></option>');

                    if (stateId) {
                        $.ajax({
                            url: "{{ url('cities') }}" + "/" + stateId,
                            type: 'GET',
                            success: function (data) {
                                $.each(data.data, function (key, value) {
                                    citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            },
                            error: function (error) {
                                console.error('Error fetching cities:', error);
                            }
                        });

                        filterAds(type, type === 'featured' ? featuredAds : latestAds);
                    }
                });

                // Event listeners for select and checkbox changes
                $(`.city_id_${type}`).change(function () {
                    filterAds(type, type === 'featured' ? featuredAds : latestAds);
                });


            }

            filterAds('featured', featuredAds);
            filterAds('latest', latestAds);
            initSelects('featured');
            initSelects('latest');
        })
        ;

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
