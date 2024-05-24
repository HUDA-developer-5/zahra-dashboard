@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.About us')])

        <div id="about-us" class="mb-5">
            <div class="container">
                <div class="card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-7 order-2 order-md-1 text-center text-md-start">
                            <h2 class="fw-bold mb-3">{{ $dynamicPage['pageContent']->{"title_".app()->getLocale()} }}</h2>
                            {!! $dynamicPage['pageContent']->{"content_".app()->getLocale()} !!}
                        </div>
                        <div class="col-md-5 order-1 order-md-2 mb-3 mb-md-0">
                            <div class="img text-center">
                                <img src="{{ asset('frontend/assets/images/about-img.png') }}" alt="about image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card statistics">
                    <h2 class="fw-bold mb-4">{{ trans('web.We Are Global And Grow') }}</h2>
                    <div class="row">
                        <div class="col-lg-4 text-center">
                            <h3 class="num fw-bold">+{{ $dynamicPage['products'] }}</h3>
                            <p class="title fw-400">{{ trans('web.Products') }}</p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <h3 class="num fw-bold">+{{ $dynamicPage['users'] }}</h3>
                            <p class="title fw-400">{{ trans('web.Sellers') }}</p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <h3 class="num fw-bold">+{{ $dynamicPage['countries'] }}</h3>
                            <p class="title fw-400">{{ trans('web.Countries') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
