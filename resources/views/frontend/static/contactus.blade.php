@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.Contact us')])
        <div id="contact-us" class="mb-5">
            <div class="container">
                <div class="card">
                    <h2 class="fw-bold mb-3">{{ trans('web.Contact us') }}</h2>
                    <div class="row align-items-center">
                        <div class="col-md-7 order-2 order-md-1">
                            <div class="contact-form">
                                {{ html()->form('post', route('web.contactus.store'))->open() }}
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <div class="form-input  mb-3">
                                            <input type="text" id="contact-title" name="title"
                                                   value="{{ old('title') }}" class="form-control"
                                                   placeholder="{{ trans('web.Title (optional)') }}">
                                            <label class="form-label"
                                                   for="contact-title">{{ trans('web.Title (optional)') }}</label>
                                            @if($errors->contactus->has("title"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->contactus->first("title") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-input mb-3">
                                            <input type="text" id="contact-name" name="name" value="{{ old('name') }}"
                                                   class="form-control" placeholder="{{ trans('web.Name') }}" required>
                                            <label class="form-label" for="contact-name">{{ trans('web.Name') }}</label>
                                            @if($errors->contactus->has("name"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->contactus->first("name") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-input mb-3">
                                            <input type="text" id="contact-phone" name="phone_number"
                                                   class="form-control" value="{{ old('phone_number') }}"
                                                   placeholder="{{ trans('web.Phone Number') }}" required>
                                            <label class="form-label" for="contact-phone">{{ trans('web.Phone Number') }}</label>
                                            @if($errors->contactus->has("phone_number"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->contactus->first("phone_number") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-input mb-3">
                                            <input type="email" id="contact-email" name="email" value="{{ old('email') }}"
                                                   class="form-control" placeholder="{{ trans('web.Email (optional)') }}">
                                            <label class="form-label" for="contact-email">{{ trans('web.Email (optional)') }}</label>
                                            @if($errors->contactus->has("title"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->contactus->first("title") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-input mb-3">
                                            <textarea name="message" id="contact-message" rows="5"
                                                      placeholder="{{ trans('web.Message') }}" class="form-control" required>{{ old('message') }}</textarea>
                                            <label class="form-label" for="contact-message">{{ trans('web.Message') }}</label>
                                            @if($errors->contactus->has("message"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->contactus->first("message") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-gradiant fw-bold"
                                            type="submit">{{ trans('web.Submit') }}</button>
                                </div>
                                {{ html()->form()->close() }}
                            </div>
                        </div>
                        <div class="col-md-5 order-1 order-md-2">
                            <div class="img text-center">
                                <img src="{{ asset('frontend/assets/images/contact-img.png') }}"
                                     alt="contact image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
