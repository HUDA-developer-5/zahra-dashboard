@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => $title])

        <div id="about-us" class="mb-5">
            <div class="container">
                <div class="card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-7 order-2 order-md-1 text-center text-md-start">
                            <h2 class="fw-bold mb-3">{{ $dynamicPage->{"title_".app()->getLocale()} }}</h2>
                            {!! $dynamicPage->{"content_".app()->getLocale()} !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
