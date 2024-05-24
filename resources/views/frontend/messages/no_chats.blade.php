@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')

    <div id="main-wrapper">
        <div id="notification-list" class="py-5">
            <div class="container">
                <h2 class="fw-bold mb-3">{{ trans('web.Messages') }}</h2>
                <div class="nodata">
                    <img src="{{ asset('frontend/assets/images/no-message.png') }}" alt="no message image" class="mb-3">
                    <p class="fw-600 mb-0">{{ trans('web.There are no messages') }}</p>
                </div>
            </div>
        </div>
    </div>

@stop

@section("script")

@endsection
