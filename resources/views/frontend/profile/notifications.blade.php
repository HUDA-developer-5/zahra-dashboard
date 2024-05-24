@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        <div id="notification-list" class="py-5">
            <div class="container">
                <h2 class="fw-bold mb-3">{{ trans('web.Notifications') }}</h2>
                @if(auth('users')->user()->notifications->count())
                    <div class="notify-list">
                        <ul>
                            @foreach(auth('users')->user()->notifications()->latest()->get() as $notification)
                                <li>
                                    <div class="d-flex align-items-start gap-2">
                                        <img src="{{  ($notification->targetUser?->image)? $notification->targetUser?->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                             alt="profile-img" loading="lazy">
                                        <div class="flex-grow-1">
                                            <div class="d-flex flex-wrap justify-content-between">
                                                <div>
                                                    <h6 class="name fw-bold mb-0">{{ $notification->{"title_".app()->getLocale()} }}</h6>
                                                    <p class="content mb-1">{{ $notification->{"content_".app()->getLocale()} }}</p>
                                                    <a href="{{ route('web.products.show', ['id' => $notification->payload['advertisement_id'], 'notification'=> $notification->id]) }}" class="text-primary fw-bold">{{ trans('web.View Comment') }}</a>
                                                </div>
                                                <p class="date fs-7 text-gray mb-0">{{ $notification->created_at->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="nodata">
                        <img src="{{ asset('frontend/assets/images/push-notifications.png') }}" alt="nodata image" class="mb-3">
                        <p class="fw-600 mb-0">{{ trans('web.There are no notification yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
