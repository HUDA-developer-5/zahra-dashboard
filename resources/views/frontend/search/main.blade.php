@extends(\App\Enums\ConstantEnums::FEL.'.master')

@section("style")
    <link href="{{ asset("Frontend/assets/css/bootstrap.min.css") }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/hover.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/aos.css") }}" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/general.css") }}" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/header.css") }}" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/justselect.min.css") }}" rel="stylesheet"/>
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/plain">
    <link href="{{ asset("Frontend/assets/css/home.css") }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{ asset("Frontend/assets/css/search.css") }}" rel="stylesheet"/>
    <link href="{{ asset("Frontend/assets/css/shap.css") }}" rel="stylesheet"/>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6yohSe89WiHJXhZCUA6wSNQnCEzySQVc&callback=initMap&libraries=&v=weekly"
        defer
    ></script>

@stop
@section('content')

    @includeIf('Frontend.search.advanced_search')

    <section class="bg-white alarmMenu notHide">
        <div class="container text-right pt-3 pb-2">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @if($saved_search_results && $saved_search_results->count() > 0)
                        <h6 class="font-weight-bold txtNotify">{{ __('main.Notification lists') }} ({{ $saved_search_results->count() }})
                            <img src="{{asset('frontend/assets/imgs/arrowLeft.PNG')}}" width="35" class="arrowAngle" alt="Qorra">
                        </h6>
                    @endif
                </div>
                <div class="col-lg-6 col-md-4">
                    @if(auth()->guard("customers")->check())
                        <button id="SubmitSavedSearch" class="btn bg-white font-weight-bold border-0 pt-0 newTextColor">{{ __('main.Save search list for alert lists') }}</button>
                    @endif
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="dropdown">
                        <button class="btn -bg-white font-weight-bold border-0 pt-0 txtTrteeb dropdown-toggle"
                                id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{ __('main.Sort by newest') }}
                            <img src="{{ asset('frontend/assets/imgs/sort.PNG') }}" alt="Qorra">
                        </button>
                        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
                            <li>
                                <label>
                                    <input type="checkbox" name="order_by_date" @if(request()->has('sort_by_date') && request()->get('sort_by_date') == 'latest') checked @endif class="order_by_date" value="latest">
                                    {{ __('main.the most recent') }}
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="order_by_date" class="order_by_date"
                                           @if(request()->has('sort_by_date') && request()->get('sort_by_date') == 'oldest') checked @endif
                                           value="oldest"> {{ __('main.the oldest') }}
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="order_by_price" class="order_by_price" value="latest" @if(request()->has('sort_by_price') && request()->get('sort_by_price') == 'latest') checked @endif>
                                    {{ __('main.The lowest price') }}
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="order_by_price" class="order_by_price"
                                           value="oldest" @if(request()->has('sort_by_price') && request()->get('sort_by_price') == 'oldest') checked @endif> {{ __('main.Highest price') }}
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @includeIf('Frontend.search.saved_search_list')

    @includeIf('Frontend.search.results')
@stop

@section("script")
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <script src="{{ asset("Frontend/assets/js/aos.js") }}"></script>
    <script src="{{ asset("Frontend/assets/js/justselect.min.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script>
        jQuery(function () {
            AOS.init();
        });
        jQuery(window).on('load', function () {
            AOS.refresh();
        });
    </script>
    <!-- script for the checkboxs in the header -->
    <script>
        $('.c-filter__toggle').click(function (event) {
            event.preventDefault();
            $(this).toggleClass('c-filter__toggle--active')
            $('.c-filter__ul').toggleClass('c-filter__ul--active')
            $(this).parent().parent().addClass('focused')
        })
        $(".c-filter__toggle").blur(function () {
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val() + " ";
            });
            if (val.length === 0) {
                $('button.c-filter__toggle').html('اين ستنتقل')
                $(".c-filter__toggle").parent().parent().removeClass('focused')
            }
        });
        $('.c-filter__item input').click(function (event) {
            var val = [];

            var x = 1;
            $(':checkbox:checked').each(function (i) {
                if (x < $(':checkbox:checked').length) {
                    val[i] = $(this).val() + ", ";
                } else {
                    val[i] = $(this).val() + " ";
                }
                x++;


                $('button.c-filter__toggle').html(val)
            })
        })
    </script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper2 = new Swiper('.most-viewed .swiper-container', {
            slidesPerView: 3,
            spaceBetween: 30,
            loopedSlides: 4,

            navigation: {
                nextEl: '.most-viewed .swiper-button-next',
                prevEl: '.most-viewed .swiper-button-prev',
                el: '.most-viewed .pagination-container',
                clickable: true,
            },
            breakpoints: {
                300: {
                    mousewheel: true,
                    keyboard: true,
                    slidesPerView: 1,
                    spaceBetween: 24,
                    allowSlidePrev: true,
                    allowSlideNext: true,
                    loopedSlides: 1,
                },
                400: {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    allowSlidePrev: true,
                    allowSlideNext: true,
                    loopedSlides: 1,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                    loopedSlides: 1,
                    allowSlidePrev: true,
                    allowSlideNext: true
                },
                700: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                    loopedSlides: 4,
                },
                1000: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    loopedSlides: 4,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                    loopedSlides: 4,
                }
            },

        });

    </script>
    <script src="{{ asset("Frontend/assets/js/main.js") }}"></script>
    <script src="https://unpkg.com/flipping@0.5.3/dist/flipping.animationFrame.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rxjs/6.5.3/rxjs.umd.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- for flats -->
    <script src="{{ asset("Frontend/assets/js/shap.js") }}"></script>

    <script>
        (function () {

            var Menu = (function () {
                var burger = document.querySelector('.burger');
                var menu = document.querySelector('.menu');
                var menuList = document.querySelector('.menu__list');
                var menuContainer = document.querySelector('.nav-container');
                var menuItems = document.querySelectorAll('.menu__item');

                var active = false;

                var toggleMenu = function () {
                    if (!active) {
                        menu.classList.add('menu--active');
                        menuContainer.classList.add('menuContainer');
                        menuList.classList.add('menu__list--active');

                        burger.classList.add('burger--close');
                        for (var i = 0, ii = menuItems.length; i < ii; i++) {
                            menuItems[i].classList.add('menu__item--active');
                        }

                        active = true;
                    } else {
                        menu.classList.remove('menu--active');
                        menuList.classList.remove('menu__list--active');
                        menuContainer.classList.remove('menuContainer');
                        burger.classList.remove('burger--close');
                        for (var i = 0, ii = menuItems.length; i < ii; i++) {
                            menuItems[i].classList.remove('menu__item--active');
                        }

                        active = false;
                    }
                };

                var bindActions = function () {
                    burger.addEventListener('click', toggleMenu, false);
                };

                var init = function () {
                    bindActions();
                };

                return {
                    init: init
                };

            }());

            Menu.init();

        }());
        $(document).ready(function () {
            $('.willHide').hide();
            $('.advanceSearch').click(function () {
                $('.willHide').hide();
                $('.filterSection').css("display", "none");
                $('.notHide').css("display", "none");
                $('.newSerchAdv').css({"margin-top": "5.5rem", "display": "block"});
            });
            $('.closeTime').click(function () {
                $('.newSerchAdv').css("display", "none");
                $('.filterSection').css("display", "block");
                $('.willHide').hide();
                $('.notHide').css("display", "block");
            });
            $('.closeNotifications').click(function () {
                $('.willHide').hide();
            });
            $('.txtNotify').click(function () {
                $('.willHide').show();
                $('.notHide').css("display", "none");
            });
            $('.closeNotificationsH').click(function () {
                $('.notHide').css("display", "block");
                $('.willHide').css("display", "none");
            });
        });
    </script>


    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 7,
                center: { lat: 30.70, lng: 30.77 },
            });
            setMarkers(map);
        }

        function setMarkers(map) {
            const image = {
                url:
                    "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
                size: new google.maps.Size(20, 32),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 32),
            };
            const shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: "poly",
            };

            @foreach($map_locations as $map_location)
                new google.maps.Marker({
                    position: { lat: {{$map_location['lat']}}, lng: {{$map_location['lng']}} },
                    map,
                    // icon: image,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    shape: shape,
                    title: "{{$map_location['title']}}",
                    zIndex: {{$map_location['index']}},
                });
            @endforeach
        }

        $(".checkbox-menu").on("change", "input[type='checkbox']", function () {
            $(this).closest("li").toggleClass("active", this.checked);
        });

        $(document).on('click', '.allow-focus', function (e) {
            e.stopPropagation();
        });
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
    <script>
        // Date picker
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
    <script>
        @if ($errors->any())
        $("#interested").modal("show")
        @endif
    </script>

    <script>
        $('.order_by_date').click(function () {
            $('.order_by_date').each(function () {
                $(this).prop('checked', false);
            });
            $(this).prop('checked', true);
            $('#sort_by_date').val(this.value);
            $('#AdvancedSearchForm').submit();
        });

        $('.order_by_price').click(function () {
            $('#order_by_price').each(function () {
                $(this).prop('checked', false);
            });
            $(this).prop('checked', true);
            $('#sort_by_price').val(this.value);
            $('#AdvancedSearchForm').submit();
        });

        $('#SubmitSavedSearch').click(function (){
            $('#saveSearchResult').val('save');
            $('#AdvancedSearchForm').submit();
        });
    </script>
@endsection
