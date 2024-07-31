@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @includeIf('frontend.components.top_title', ['title' => trans('web.Advertisement details')])

        <div id="product-banner" class="mb-4">
            <div class="container">
                <div class="pro-slider">
                    <div class="model-list">
                        <div class="d-flex gap-2">
                            @if($product->type == \App\Enums\Advertisement\AdvertisementTypeEnums::Premium->value)
                                <a href="javascript:void(0)" class="best">
                                    <img src="{{ asset('frontend/assets/images/icons/crown.svg') }}" alt="crown icon"
                                         loading="lazy">
                                </a>
                            @endif

                            @if(auth('users')->check())
                                @if(auth('users')->user()->id != $product->user_id)
                                    @includeIf("frontend.components.fav_icon", ["isFav" => $product->is_favourite, "product_id"=>$product->id])

                                    @if(auth('users')->user()->id != $product->user_id)
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                           data-bs-target="#adsReportModal"
                                           class="flag"><i class="far fa-flag"></i></a>
                                    @endif
                                @endif

                                @if(auth('users')->user()->id == $product->user_id)
                                    <a href="{{ route('web.products.edit', ['id'=>$product->id]) }}" class="edit"><i
                                            class="far fa-pen-to-square"></i></a>
                                @endif
                            @endif
                            {{--                            <a href="javascript:void(0)" class="share"><i class="fas fa-share-nodes"></i></a>--}}
                            <div class="sharethis-inline-share-buttons"></div>
                        </div>
                    </div>

                    <div class="slider slider-single">
                        @if($product->images->count() > 0)
                            @foreach($product->images as $productImage)
                                <div>
                                    <a href="{{ $productImage->file_path }}" data-fancybox="gallery">
                                        <img src="{{ $productImage->file_path }}" alt="{{ $product->name }}">
                                    </a>
                                </div>
                            @endforeach
                        @elseif($product->image_path)
                            <div>
                                <a href="{{ $product->image_path }}" data-fancybox="gallery">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                        @else
                            <div>
                                <a href="{{ asset('frontend/assets/images/icon.png') }}" data-fancybox="gallery">
                                    <img src="{{ asset('frontend/assets/images/icon.png') }}"
                                         alt="{{ $product->name }}">
                                </a>
                            </div>
                        @endif

                        @if($product->videos->count() > 0)
                            @foreach($product->videos as $productVideo)
                                <div>
                                    <a href="{{ $productVideo->file_path }}" data-fancybox="gallery">
                                        <video width="100%" height="360" controls>
                                            <source src="{{ $productVideo->file_path }}" type="video/mp4">
                                        </video>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="slider slider-nav">
                        @if($product->images->count() > 0)
                            @foreach($product->images as $productImage)
                                <div>
                                    <a href="{{ $productImage->file_path }}" data-fancybox="gallery">
                                        <img src="{{ $productImage->file_path }}" alt="{{ $product->name }}">
                                    </a>
                                </div>
                            @endforeach
                        @elseif($product->image_path)
                            <div>
                                <a href="{{ $product->image_path }}" data-fancybox="gallery">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                        @else
                            <div>
                                <a href="{{ asset('frontend/assets/images/icon.png') }}" data-fancybox="gallery">
                                    <img src="{{ asset('frontend/assets/images/icon.png') }}"
                                         alt="{{ $product->name }}">
                                </a>
                            </div>
                        @endif

                        @if($product->videos->count() > 0)
                            @foreach($product->videos as $productVideo)
                                <div>
                                    <a href="{{ asset('frontend/assets/images/video-poster.png') }}"
                                       data-fancybox="gallery">
                                        <img src="{{ asset('frontend/assets/images/video-poster.png') }}"
                                             alt="{{ $product->name }}">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div id="product-desc" class="mb-4">
            <div class="container">
                <div class="card">
                    <div class="d-flex justify-content-between fs-7 mb-2">
                        <span class="cat text-secondary">#{{ $product->category?->name }}</span>
                        <span> {{ $product->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="title text-dark fw-bold mb-2">{{ $product->name }}</h5>
                        @if($product->price_type == \App\Enums\Advertisement\AdvertisementPriceTypeEnums::Fixed->value)
                            <p class="price text-primary fw-bold fs-5 mb-2">{{ $product->default_price }} {{ trans('web.'.$product->currency) }}</p>
                        @else
                            <div class="text-md-end">
                                @if(auth('users')->check() && auth('users')->user()->id != $product->user_id)
                                    @auth('users')
                                        @if($product->is_sold == 0 && $product->price_type == \App\Enums\Advertisement\AdvertisementPriceTypeEnums::OpenOffer->value)
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                               data-bs-target="#offerModal"
                                               class="text-success fs-7 fw-bold mb-0 addProductAction"
                                               data-id="{{ $product->id }}"
                                               data-action="openOffer">{{ trans('web.Open offer') }}</a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                           data-bs-target="#beforeLoginModal"
                                           class="text-success fs-7 fw-bold mb-0">{{ trans('web.Open offer') }}</a>
                                    @endauth
                                @endif

                                <p class="price text-primary fw-bold fs-5 mb-2">
                                    <span class="fs-6 text-gray me-1">{{ trans('web.highest offer') }} :</span>
                                    {{ $product->max_offer_price }} {{ trans('web.'.$product->currency) }}
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-2 user">
                        <div class="img">
                            <img src="{{ ($product->owner_image) ?: asset('frontend/assets/images/icons/profile-circle.svg')}}"
                                 alt="image">
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $product->owner_name }}</h6>
                            <div class="location">
                                <span class="icon me-1"><i class="fas fa-location-dot"></i></span>
                                <span>{{ $product->nationality?->name }} {{ $product->nationality?->city?->name }}</span>
                            </div>
                            <div class="user-tooltip">
                                <div class="info mb-3">
                                    <div class="img mb-2"><img
                                            src="{{ ($product->owner_image) ?: asset('frontend/assets/images/icons/profile-circle.svg')}}"
                                            alt="image"></div>
                                    <h6 class="fw-bold mb-0">{{ $product->owner_name }}</h6>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <div class="adv">
                                        <span><img src="{{ asset('frontend/assets/images/icons/shield-tick.svg') }}"
                                                   alt="shield icon"></span>
                                        <span>{{ trans('web.Essetion') }}</span>
                                    </div>
                                    <div class="adv">
                                        <span><img src="{{ asset('frontend/assets/images/icons/star.svg') }}"
                                                   alt="star icon"></span>
                                        <span>{{ trans('web.Cuppidate') }}</span>
                                    </div>
                                    <div class="adv">
                                        <span><img src="{{ asset('frontend/assets/images/icons/crown.svg') }}"
                                                   alt="crown icon"></span>
                                        <span>{{ trans('web.Tag') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btns d-flex flex-wrap justify-content-sm-end gap-2 mt-3 mt-sm-0">
                        @if(auth('users')->check() && auth('users')->user()->id != $product->user_id)
                            @if($product->is_sold == 0 && $product->price_type != \App\Enums\Advertisement\AdvertisementPriceTypeEnums::OpenOffer->value)
                                <a href="#" class="btn btn-gradiant btn-chat addProductAction"
                                   data-id="{{ $product->id }}"
                                   data-action="chat">
                                    <span class="me-2"><i class="far fa-comments"></i></span>
                                    <span>{{ trans('web.Chat') }}</span>
                                </a>

                                <a target="_blank" href="https://wa.me/{{ $product->whatsapp_number }}"
                                   class="btn btn-border btn-whatsapp addProductAction" data-id="{{ $product->id }}"
                                   data-action="whatsapp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>{{ trans('What’s up') }}</span>
                                </a>

                                <a href="tel:{{$product->phone_number}}"
                                   class="btn btn-border btn-call addProductAction"
                                   data-id="{{ $product->id }}" data-action="call">
                                    <i class="fas fa-phone-volume"></i></a>
                            @endif

                            @if($product->is_sold == 1 && $product->user_id && auth('users')->id() != $product->user_id)
                                <a href="{{ route('web.products.purchased', ['id' => $product->id]) }}"
                                   class="btn btn-gradiant btn-purchased"><span class="me-2"><i
                                            class="fas fa-basket-shopping"></i></span><span>I {{ trans('web.Purchased') }}</span></a>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="product-details" class="mb-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between mb-2">
                    <h3 class="text-dark fw-bold">{{ trans('web.Description') }}</h3>
                    <a href="javascript:void(0)" class="text-primary" id="translateDescription"><span class="me-2"><img
                                src="{{ asset('frontend/assets/images/icons/translate.svg') }}"
                                alt="icon"></span><span>{{ trans('web.translate') }}</span></a>
                </div>
                <p>{{ $product->description }}</p>
                <p id="translatedDescription"></p>
            </div>
        </div>


        <div id="product-comments" class="mb-4">
            <div class="container">
                <div class="card">
                    <h4 class="fw-bold">{{ trans('web.Comments') }} <span class="text-primary fw-400">({{ $product->comments_count }})</span>
                    </h4>
                    <div id="commentsList">
                        {{-- Comments will be loaded here via AJAX --}}
                    </div>
                    @include('frontend.components.add_comment', ['product_id' => $product->id, 'parent_id' => null])
                </div>
            </div>
        </div>


        <div id="product-related" class="mb-4">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <h4>{{ trans('web.related ads') }}</h4>
                    <a href="{{ route('web.products.search', ['categories_id[]' => $product->category_id]) }}"
                       class="text-primary">{{ trans('web.See More') }}</a>
                </div>
                <div class="ads-list-sec">
                    <div class="row">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                                @include('frontend.components.product_card', ['product' => $relatedProduct])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($product->is_sold == 0)
        @include("frontend.components.open_offer", ["product_image" => $product->image_path, "product_name"=>$product->name, 'product_id'=>$product->id])
    @endif
    @include("frontend.components.report_product", ['product_id'=>$product->id])
@stop

@section("script")
        <script>
            $(document).ready(function () {
            $("#translateDescription").on('click', function () {
                $("#translatedDescription").html('');
                $.ajax({
                    type: "get",
                    url: "{{ route('web.products.translate', ['id' => $product->id]) }}",
                    success: function (data) {
                        if (data.success) {
                            $("#translatedDescription").html(data.data);
                        }
                    }
                });
            });
        });
    </script>show

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            // Load comments
            function loadComments() {
                $.ajax({
                    url: '{{ route("comments.get", $product->id) }}',
                    type: 'GET',
                    success: function (data) {
                        if (data.success) {
                            $('#commentsList').html(data.html);
                            bindCommentActions(); // Bind actions to new elements
                        }
                    }
                });
            }

            // Initial load
            loadComments();

            // Handle comment form submission
            $('#CommentForm').submit(function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('comments.add') }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            $('#commentsList').append(data.html);
                            $('#CommentForm')[0].reset();
                            bindCommentActions(); // Re-bind actions to new elements
                        }
                    }
                });
            });

            // Function to bind actions to new elements
            function bindCommentActions() {
                $('.btn-replay').off('click').on('click', function () {
                    @auth('users')
                    var commentId = $(this).data('id');
                    var formHtml = `
                <div class="comment replay with-form-reply">
                    <div class="d-flex gap-2 ">
                        <div class="img">
                            <img src="{{ auth('users')->user()->image ?? asset('frontend/assets/images/icons/profile-circle.svg') }}" alt="user image">
                        </div>
                        <div class="user-details flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-dark fw-bold">{{ auth('users')->user()->name }}</h6>
                            </div>
                            <form method="post" action="{{ route('comments.add') }}" id="ReplayForm-${commentId}">
                                @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="parent" value="${commentId}">
                                <textarea name="comment" required rows="2" placeholder="{{ trans('web.Replay') }}" class="form-control" maxlength="250"></textarea>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-gradiant btn-send-replay py-1 px-4 mt-2">{{ trans('web.Send') }}</button>
                                    <a href="javascript:void(0);" class="btn btn-border btn-cancel-replay py-1 px-4 mt-2">{{ trans('web.Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>`;
                    $(this).closest('.comment').append(formHtml);
                    bindReplayFormActions(commentId);
                    @endauth
                });

                $('.btn-edit').off('click').on('click', function () {
                    var commentId = $(this).data('id');
                    var commentText = $(this).closest('.comment').find('.msg-content').text();
                    var formHtml = `
                <form method="post" action="{{ url('/comments/edit/') }}/${commentId}" class="edit-form">
                    @csrf
                    <textarea name="comment" rows="2" class="form-control">${commentText}</textarea>
                    <div class="d-flex gap-2">
                        <button class="btn btn-gradiant btn-edit-comment py-1 px-4 mt-2" type="submit">{{ trans('web.Send') }}</button>
                        <button class="btn btn-border btn-cancel-form py-1 px-4 mt-2" type="button">{{ trans('web.Cancel') }}</button>
                    </div>
                </form>`;
                    $(this).closest('.comment').find('.user-details').append(formHtml);
                    bindEditFormActions();
                });

                $('.btn-delete').off('click').on('click', function () {
                    var commentId = $(this).data('id');

                    $.ajax({
                        url: `/comments/delete/${commentId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.success) {
                                $(`.comment[data-id=${commentId}]`).remove();
                            }
                        }
                    });
                });
            }

            function bindReplayFormActions(commentId) {
                $(`#ReplayForm-${commentId}`).submit(function (e) {
                    e.preventDefault();
                    let formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route('comments.add') }}',
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            if (data.success) {
                                loadComments();
                            }
                        }
                    });
                });

                $(`#ReplayForm-${commentId} .btn-cancel-replay`).off('click').on('click', function () {
                    $(this).closest('.comment').find('.with-form-reply').remove();
                });
            }

            function bindEditFormActions() {
                $('.edit-form').submit(function (e) {
                    e.preventDefault();
                    let formData = $(this).serialize();
                    let actionUrl = $(this).attr('action');

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            if (data.success) {
                                loadComments();
                            }
                        }
                    });
                });

                $('.btn-cancel-form').off('click').on('click', function () {
                    $(this).closest('.edit-form').remove();
                });
            }
        });
    </script>
@endsection
