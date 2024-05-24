@extends('frontend.layouts.master')

@section("style")

@stop
@section('content')

    <div id="main-wrapper">
        @include('frontend.components.top_title', ['title' => trans('web.profile')])

        <div id="profile" class="mb-5">
            <div class="container">
                <div class="row">
                    @include('frontend.components.side_menu', ['title' => trans('web.profile')])
                    <div class="col-lg-9">
                        <div class="profile-form">
                            <div class="general-info">
                                <h5 class="fw-600 mb-3">{{ trans('web.General Information') }}</h5>
                                {{ html()->form('post', route('web.update_profile'))->acceptsFiles()->open() }}
                                <div class="profile-img">
                                    <div class="img">
                                        <img src="{{ (!empty($user->image_path)) ? $user->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                             alt="profile image"
                                             class="profile-image">
                                        <div class="img-upload">
                                            <div class="img-upload-select">
                                                <div class="img-select-button icon">
                                                    <i class="far fa-pen-to-square"></i>
                                                </div>
                                                <input type="file" name="image" id="img-upload-input">
                                            </div>
                                        </div>
                                    </div>
                                    @if($errors->has("image"))
                                        <div class="error-note">
                                            <span class="help-block text-danger">{{ $errors->first("image") }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="form-input validate-input mb-3">
                                            <input type="text" id="profile-first-name" name="name"
                                                   class="form-control requiredInput only-text"
                                                   placeholder="{{ trans('web.Full name') }}" value="{{ $user->name }}"
                                                   maxlength="50" required>
                                            <label class="form-label"
                                                   for="profile-name">{{ trans('web.Full name') }}</label>
                                            @if($errors->has("name"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->first("name") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-input validate-input mb-3">
                                            <input type="email" id="profile-email" name="email"
                                                   class="form-control email" placeholder="{{ trans('web.Email') }}"
                                                   value="{{ $user->email }}" required>
                                            <label class="form-label"
                                                   for="profile-email">{{ trans('web.Email') }}</label>
                                            @if($errors->has("email"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->first("email") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-input validate-input mb-3">
                                            <input type="phone" id="profile-phone" name="phone_number"
                                                   class="form-control phone"
                                                   placeholder="{{ trans('web.Phone Number') }}"
                                                   value="{{ $user->phone_number }}" maxlength="16" required>
                                            <label class="form-label"
                                                   for="profile-phone">{{ trans('web.Phone Number') }}</label>
                                            @if($errors->has("phone_number"))
                                                <div class="error-note">
                                                    <span class="help-block text-danger">{{ $errors->first("phone_number") }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        @if(isset($countries))
                                            <select class="select2 w-100 form-control" name="nationality_id">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            @if($user->nationality_id && $user->nationality_id == $country->id) selected @endif> {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-gradiant fw-bold"
                                            type="submit">{{ trans('web.Update') }}</button>
                                </div>
                                {{ html()->form()->close() }}
                            </div>
                            <div class="changed-pass">
                                <h5 class="fw-600 mb-3">{{ trans('web.Change Password') }}</h5>
                                {{ html()->form('post', route('web.change_password'))->open() }}
                                <div class="form-input validate-input mb-3">
                                    <div>
                                        <input type="password" id="old-password" name="old_password"
                                               class="form-control password"
                                               placeholder="{{ trans('web.Old Password') }}" maxlength="20"
                                               required>
                                        <label class="form-label"
                                               for="old-password">{{ trans('web.Old Password') }}</label>
                                        <div class="icon password-show"><i class="far fa-eye"></i></div>
                                    </div>
                                    @if($errors->has("old_password"))
                                        <div class="error-note">
                                            <span class="help-block text-danger">{{ $errors->first("old_password") }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-input validate-input mb-3">
                                    <div>
                                        <input type="text" id="changed-password"
                                               name="new_password" class="form-control password2"
                                               placeholder="{{ trans('web.New Password') }}" maxlength="20" required>
                                        <label class="form-label"
                                               for="changed-password">{{ trans('web.New Password') }}</label>
                                        <div class="icon password-show"><i class="far fa-eye-slash"></i></div>
                                    </div>
                                    @if($errors->has("new_password"))
                                        <div class="error-note">
                                            <span class="help-block text-danger">{{ $errors->first("new_password") }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-input validate-input mb-3">
                                    <div>
                                        <input type="text" id="changed-confirm-password"
                                               name="new_password_confirmation" class="form-control password3"
                                               placeholder="{{ trans('web.Confirm Password') }}" maxlength="20"
                                               required>
                                        <label class="form-label"
                                               for="changed-confirm-password">{{ trans('web.Confirm Password') }}</label>
                                        <div class="icon password-show"><i class="far fa-eye-slash"></i></div>
                                    </div>
                                    @if($errors->has("new_password_confirmation"))
                                        <div class="error-note">
                                            <span class="help-block text-danger">{{ $errors->first("new_password_confirmation") }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-gradiant fw-bold">{{ trans('web.Change') }}</button>
                                </div>
                                {{ html()->form()->close() }}
                            </div>
                            <div class="delete-account">
                                <h5 class="fw-600 mb-3">{{ trans('web.Delete Account') }}</h5>
                                <p>{{ trans('web.Are you sure you want to delete your account? If you delete your account, you may not be able to sign in again.') }}</p>
                                <div class="text-end">
                                    <a href="{{ route('web.delete_account') }}"
                                       class="btn btn-gradiant fw-bold">{{ trans('web.Delete Account') }}</a>
                                </div>
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
