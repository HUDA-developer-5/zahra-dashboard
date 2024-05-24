@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.My Ads')])
        <div id="my-ads" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu', ['title' => trans('web.My Ads')])

                    @if($products->count())
                        <div class="col-lg-9">
                            <div class="ads-list-sec">
                                @foreach($products as $product)
                                    <div class="card d-block d-md-flex flex-row gap-3 mb-3">
                                        <div class="card-side mb-3 mb-md-0">
                                            <img src="{{ $product->image_path }}" alt="{{ $product->name }}"
                                                 loading="lazy" class="h-100">
                                            <div class="d-flex align-items-center justify-content-between top-card">
                                                {{--                                            <div class="wishlist"><i class="far fa-heart"></i></div>--}}
                                                @includeIf("frontend.components.fav_icon", ["isFav" => $product->is_favourite, "product_id"=>$product->id])
                                                @if($product->is_negotiable)
                                                    <div class="negotiable">{{ trans('web.Negotiable') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ads-details flex-grow-1">
                                            <div class="d-flex justify-content-between fs-7 mb-2">
                                                <span class="cat text-secondary"># {{ $product->category?->name }}</span>
                                                <span> {{ $product->created_at->format('Y/m/d') }}</span>
                                            </div>
                                            <h5 class="title"><a
                                                        href="{{ route('web.products.show', ['id'=>$product->id]) }}">{{ $product->name }}</a>
                                            </h5>
                                            <div class="location mb-2">
                                                <span class="icon me-2"><i class="fas fa-location-dot"></i></span>
                                                <span class="text-dark">{{ $product->nationality?->name }} {{ $product->nationality?->city?->name }}</span>
                                            </div>
                                            <p class="price text-primary fw-bold fs-5 mb-2">{{ $product->default_price }} {{ trans('web.'.$product->currency) }}</p>
                                            <div class="btns d-flex justify-content-sm-end gap-2">
                                                <a href="{{ route('web.products.show', ['id'=>$product->id]) }}"
                                                   class="btn btn-gradiant btn-view">
                                                    <span class="me-2"><i class="far fa-eye"></i></span>
                                                    <span>{{ trans('web.View') }}</span>
                                                </a>
                                                <a href="{{ route('web.products.edit', ['id'=>$product->id]) }}" class="btn btn-border">
                                                    <span class="me-2"> <i class="fa-solid fa-pen"></i> </span>
                                                    <span>{{ trans('web.Edit') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
