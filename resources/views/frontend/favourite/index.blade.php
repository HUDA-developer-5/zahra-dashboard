@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.My Favourites')])
        <div id="my-ads" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu', ['title' => trans('web.My Favourites')])
                    <div class="col-lg-9">
                        <div class="ads-list-sec">
                            @if($favouriteProducts->count())
                                @foreach($favouriteProducts as $favouriteProduct)
                                    <div class="card d-flex flex-wrap flex-row gap-3 mb-3">
                                        <div class="card-side mb-3 mb-md-0">
                                            <img src="{{ $favouriteProduct->image_path}}" alt="{{ $favouriteProduct->name }}" loading="lazy" class="h-100">
                                            <div class="d-flex align-items-center justify-content-between top-card">
                                                @includeIf("frontend.components.fav_icon", ["isFav" => $favouriteProduct->is_favourite, "product_id"=>$favouriteProduct->id])
                                            </div>
                                        </div>
                                        <div class="ads-details flex-grow-1">
                                            <div class="d-flex justify-content-between fs-7 mb-2">
                                                <span class="cat text-secondary"># {{ $favouriteProduct->category?->name }}</span>
                                                <span> {{ $favouriteProduct->created_at->format('Y/m/d') }}</span>
                                            </div>
                                            <h5 class="title">{{ $favouriteProduct->name }}</h5>
                                            <div class="location mb-2">
                                                <span class="icon me-1"><i class="fas fa-location-dot"></i></span>
                                                <span class="text-dark">{{ $favouriteProduct->nationality?->name }} {{ $favouriteProduct->nationality?->city?->name }}</span>
                                            </div>
                                            <p class="price d-flex gap-3 text-primary fw-bold fs-5 mb-2">{{ $favouriteProduct->default_price }} {{ trans('web.'.$favouriteProduct->currency) }}</p>

                                            <div class="btns d-flex flex-wrap justify-content-sm-end gap-2">
                                                <a href="#" class="btn btn-gradiant btn-chat">
                                                    <span class="me-1"><i class="far fa-comments"></i></span>
                                                    <span>{{ trans('web.Chat') }}</span>
                                                </a>

                                                <a href="{{ route('web.products.show', ['id'=>$favouriteProduct->id]) }}" class="btn btn-border btn-view">
                                                    <span class="me-1"><i class="far fa-eye"></i></span>
                                                    <span>{{ trans('web.View') }}</span>
                                                </a>

                                                <a href="https://wa.me/{{ $favouriteProduct->whatsapp_number }}" class="btn btn-border btn-whatsapp w-auto">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
