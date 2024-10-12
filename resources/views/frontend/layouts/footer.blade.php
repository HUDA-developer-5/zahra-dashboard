<footer>
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-8 mb-4 mb-lg-0 pe-lg-0">
                    <div class="img mb-3">
                        <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo image" loading="lazy"
                             class="footer-logo">
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="icon">
                            <img src="{{ asset('frontend/assets/images/icons/phone.svg') }}" alt="phone icon"
                                 loading="lazy">
                        </span>
                        <span>01026958582</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="icon"><img
                                src="{{ asset('frontend/assets/images/icons/sms-tracking.svg') }}"
                                alt="sms icon" loading="lazy"></span>
                        <span>Zahra@gmail.com</span>
                    </div>
                    <div>
                        <h5 class="mb-3 w-600">Download our app</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <div>
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/google-img.png') }}"
                                         alt="google image"
                                         class="img-fluid"
                                         loading="lazy">
                                </a>
                            </div>
                            <div>
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/app-img.png') }}"
                                         alt="apple image"
                                         class="img-fluid"
                                         loading="lazy">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-4 mb-4 mb-lg-0 ps-lg-0">
                    <h5 class="fw-600 mb-3">{{ trans('web.Company') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('web.home') }}">{{ trans('web.Home') }}</a></li>
                        <li><a href="{{ route('web.categories') }}">{{ trans('web.Category') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                    <h5 class="fw-600 mb-3">{{ trans('web.Important links') }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('web.contactus.show') }}">{{ trans('web.Contact us') }}</a></li>
                                <li><a href="{{ route('web.aboutus.show') }}">{{ trans('web.About us') }}</a></li>
                                <li><a href="{{ route('web.premium.show') }}">{{ trans('web.How to be premium') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'privacy-policy']) }}">{{ trans('web.Privacy policy') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'terms-and-conditions']) }}">{{ trans('web.terms and conditions') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'special-advertisement']) }}">{{ trans('web.How do you get a special advertisement') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'selling-and-dealing-instructions']) }}">{{ trans('web.Selling and dealing instructions') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'payment-fees']) }}">{{ trans('web.Payment fees') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'safety-center']) }}">{{ trans('web.A safety center from human exploitation') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'usage-agreement']) }}">{{ trans('web.Usage agreement') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('web.dynamic.show',['slug'=>'prohibited-advertisements']) }}">{{ trans('web.Prohibited advertisements') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="fw-600 mb-3">{{ trans('web.Subscribe our newsletter') }}</h5>
                    <p>{{ trans('web.Flow our social media and get up blogs and jobs that we present especially for you') }}</p>
                    <div class="newsletter-form">
                        {{ html()->form('post', route('web.subscribe'))->open() }}
                        <div class="validate-input">
                            <div class="position-relative">
                                <input type="email" name="email" class="form-control email"
                                       placeholder="{{ trans('web.Email') }}" maxlength="30">
                                <button type="submit"
                                        class="btn btn-gradiant btn-subscribe">{{ trans('web.Subscribe') }}</button>
                            </div>
                            @if($errors->subscribe->has("email"))
                                <div class="error-note">
                                    <span class="help-block text-danger">{{ $errors->subscribe->first("email") }}</span>
                                </div>
                            @endif
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="copyright">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between gap-3 content">
                <p class="mb-0">{{ trans('web.All rights reserved') }} (558-2021)</p>
                <div class="d-flex gap-2 social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Modals -->
<div class="modal preferenceModal fade" id="preferenceModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <h3 class="text-capitalize text-center fw-bold mb-0">{{ trans('web.Preferences') }}</h3>
            </div>
            <div class="modal-body">
                {{ html()->form('post', route('web.change_lang'))->open() }}
                @if(isset($countries))
                    <div class="mb-3">
                        <select class="select2 w-100 form-control" name="country_id">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                        @if(session()->has('country_id') && session()->get('country_id') == $country->id) selected @endif> {{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <select class="select2 w-100 form-control site-lang" name="language">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <option value="{{ $localeCode }}"
                                    @if(app()->getLocale() == $localeCode) selected @endif>
                                {{ $properties['native'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="btn btn-gradiant w-100" type="submit">{{ trans('web.Save') }}</button>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
<div class="modal main-modal beforeLoginModal fade" id="beforeLoginModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h3 class="text-dark text-center fw-bold mb-3">{{ trans('web.Please log in or create an account') }}</h3>
                <a data-bs-toggle="modal" href="#loginModal" role="button"
                   class="btn btn-gradiant fw-bold w-100">{{  trans('web.Login')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal main-modal loginModal fade" id="loginModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo mb-2">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                    <h3 class="text-capitalize text-center fw-bold mb-0">{{  trans('web.Login')}}</h3>
                </div>
            </div>
            <div class="modal-body">
                {{ html()->form('post', route('login'))->open() }}
                <div class="form-input validate-input mb-3">
                    <input type="text" id="login-email" name="user_name" class="form-control phone"
                           value="{{ old('user_name') }}"
                           placeholder="{{ trans('web.Email / Phone Number') }}" required>
                    <label class="form-label" for="login-email">{{ trans('web.Email / Phone Number') }}</label>

                    @if($errors->login->has("user_name"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->login->first("user_name") }}</span>
                        </div>
                    @endif
                </div>

                <div class="form-input validate-input mb-3">
                    <div>
                        <input type="password" id="login-password" name="password" class="form-control password"
                               value="{{ old('password') }}"
                               placeholder="{{ trans('web.Password') }}" required>
                        <label class="form-label" for="login-password">{{ trans('web.Password') }}</label>
                        <div class="icon password-show"><i class="far fa-eye"></i></div>
                    </div>
                    @if($errors->login->has("password"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->login->first("password") }}</span>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between flex-column flex-sm-row">
                        <div class="form-check order-2 order-sm-1">
                            <input class="form-check-input" name="remember" type="checkbox" value="1"
                                   id="remember-1">
                            <label class="form-check-label fw-bold"
                                   for="remember-1">{{ trans('web.Remember Me') }}</label>
                        </div>
                        <div class="order-1 order-sm-2 mb-4 mb-sm-0">
                            <a data-bs-toggle="modal" href="#forgetPasswordModal" role="button"
                               class="text-primary fw-600">{{ trans('web.Forget your Password !') }}</a>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-gradiant fw-bold w-100">{{ trans('web.Login') }}</button>
                </div>
                {{ html()->form()->close() }}
                <div class="divider"><span>OR</span></div>
                <div class="by_gmail text-center mb-3">
                    <a href="{{ route('social.auth-provider', ['provider' => 'google']) }}">
                        <div class="icon">
                            <img src="{{ asset('frontend/assets/images/icons/google.svg') }}" alt="google icon"
                                 loading="lazy">
                        </div>
                        <p class="text-uppercase fw-bold mb-0">{{  trans('web.Log in by gmail')}}</p>
                    </a>
                </div>
                <div class="by_apple text-center mb-3">
                    <a href="{{ route('social.auth-provider', ['provider' => 'apple']) }}">
                        <div class="icon">
                            <img src="{{ asset('frontend/assets/images/icons/apple.svg') }}" alt="apple icon"
                                 loading="lazy">
                        </div>
                        <p class="text-uppercase fw-bold mb-0">{{  trans('web.Log in by Apple')}}</p>
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-dark">{{ trans('web.Don’t have an account?')}} </span>
                    <a data-bs-toggle="modal" href="#registerModal" role="button"
                       class="text-primary fw-bold">{{ trans('web.Register Now') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="modal main-modal registerModal fade" id="registerModal" aria-hidden="true" tabindex="-1">--}}
{{--    <div class="modal-dialog modal-dialog-centered">--}}
{{--        <div class="modal-content border-0">--}}
{{--            <div class="modal-header justify-content-center border-0">--}}
{{--                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">--}}
{{--                </button>--}}
{{--                <div class="text-center">--}}
{{--                    <div class="modal-logo mb-2">--}}
{{--                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">--}}
{{--                    </div>--}}
{{--                    <h3 class="text-capitalize text-center fw-bold mb-0">{{  trans('web.create account')}}</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                {{ html()->form('post', route('register'))->open() }}--}}
{{--                <div class="form-input  mb-3">--}}
{{--                    <input type="text" id="register-name" name="name" class="form-control username"--}}
{{--                           value="{{ old('name') }}"--}}
{{--                           placeholder="{{ trans('web.Name') }}" required>--}}
{{--                    <label class="form-label" for="register-name">{{ trans('web.Name') }}</label>--}}

{{--                    @if($errors->register->has("name"))--}}
{{--                        <div class="error-note">--}}
{{--                            <span class="help-block text-danger">{{ $errors->register->first("name") }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="form-input  mb-3">--}}
{{--                    <input type="text" id="register-email" name="email" class="form-control email"--}}
{{--                           value="{{ old('email') }}"--}}
{{--                           placeholder="{{ trans('web.Email') }}" required>--}}
{{--                    <label class="form-label" for="register-email">{{ trans('web.Email') }}</label>--}}
{{--                    @if($errors->register->has("email"))--}}
{{--                        <div class="error-note">--}}
{{--                            <span class="help-block text-danger">{{ $errors->register->first("email") }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="form-input  mb-3">--}}
{{--                    <input type="text" id="register-phone" name="phone_number" class="form-control phone"--}}
{{--                           value="{{ old('phone_number')}}"--}}
{{--                           placeholder="{{ trans('web.Phone Number') }}">--}}
{{--                    <label class="form-label" for="register-phone">{{ trans('web.Phone Number') }}</label>--}}
{{--                    @if($errors->register->has("phone_number"))--}}
{{--                        <div class="error-note">--}}
{{--                            <span class="help-block text-danger">{{ $errors->register->first("phone_number") }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="form-input  mb-3">--}}
{{--                    <div>--}}
{{--                        <input type="password" id="register-password" name="password"--}}
{{--                               class="form-control password" placeholder="{{ trans('web.Password') }}" required>--}}
{{--                        <label class="form-label" for="register-password">{{ trans('web.Password') }}</label>--}}
{{--                        <div class="icon password-show"><i class="far fa-eye"></i></div>--}}
{{--                    </div>--}}
{{--                    @if($errors->register->has("password"))--}}
{{--                        <div class="error-note">--}}
{{--                            <span class="help-block text-danger">{{ $errors->register->first("password") }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="form-input  mb-3">--}}
{{--                    <div>--}}
{{--                        <input type="password" id="register-confirm-password" name="password_confirmation"--}}
{{--                               class="form-control password2" placeholder="{{ trans('web.Confirm Password') }}"--}}
{{--                               required>--}}
{{--                        <label class="form-label" for="register-password">{{ trans('web.Confirm Password') }}</label>--}}
{{--                        <div class="icon password-show"><i class="far fa-eye"></i></div>--}}
{{--                    </div>--}}
{{--                    @if($errors->register->has("password_confirmation"))--}}
{{--                        <div class="error-note">--}}
{{--                            <span class="help-block text-danger">{{ $errors->register->first("password_confirmation") }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <div class="validate-input form-check order-2 order-sm-1">--}}
{{--                        <input class="form-check-input checkInput" name="remember" type="checkbox" value="1"--}}
{{--                               id="agree-1" required>--}}
{{--                        <label class="form-check-label fw-bold" for="flexCheckChecked-1">--}}
{{--                            {{ trans('web.By signing up, I agree with the') }}--}}
{{--                            <a data-bs-toggle="modal" href="#registerTermsModal" role="button"--}}
{{--                               class="text-decoration-underline text-primary">{{ trans('web.Terms of use & Privacy policy') }}</a>--}}
{{--                        </label>--}}
{{--                        @if($errors->register->has("remember"))--}}
{{--                            <div class="error-note">--}}
{{--                                <span class="help-block text-danger">{{ $errors->register->first("remember") }}</span>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <button class="btn btn-gradiant fw-bold w-100"--}}
{{--                            type="submit">{{ trans('web.Create an account') }}</button>--}}
{{--                </div>--}}
{{--                {{ html()->form()->close() }}--}}
{{--                <div class="divider"><span>OR</span></div>--}}
{{--                <div class="by_gmail text-center mb-3">--}}
{{--                    <a href="{{ route('social.auth-provider', ['provider' => 'google']) }}">--}}
{{--                        <div class="icon">--}}
{{--                            <img src="{{ asset('frontend/assets/images/icons/google.svg') }}" alt="google icon"--}}
{{--                                 loading="lazy">--}}
{{--                        </div>--}}
{{--                        <p class="text-uppercase fw-bold mb-0">{{  trans('web.Log in by gmail')}}l</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="by_apple text-center mb-3">--}}
{{--                    <a href="{{ route('social.auth-provider', ['provider' => 'apple']) }}">--}}
{{--                        <div class="icon">--}}
{{--                            <img src="{{ asset('frontend/assets/images/icons/apple.svg') }}" alt="apple icon"--}}
{{--                                 loading="lazy">--}}
{{--                        </div>--}}
{{--                        <p class="text-uppercase fw-bold mb-0">{{  trans('web.Log in by Apple')}}</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="mt-4 text-center">--}}
{{--                    <span class="text-dark">{{ trans('web.Already have an account') }} </span>--}}
{{--                    <a data-bs-toggle="modal" href="#loginModal" role="button"--}}
{{--                       class="text-primary fw-bold">{{ trans('web.Login') }}</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<div class="modal main-modal registerModal fade" id="registerModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo mb-2">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                    <h3 class="text-capitalize text-center fw-bold mb-0">{{ trans('web.create account') }}</h3>
                </div>
            </div>
            <div class="modal-body">
                {{ html()->form('post', route('register'))->id('registerForm')->open() }}
                <div class="form-input mb-3">
                    <input type="text" id="register-name" name="name" class="form-control username"
                           value="{{ old('name') }}"
                           placeholder="{{ trans('web.Name') }}">
                    <label class="form-label" for="register-name">{{ trans('web.Name') }}</label>
                    <div class="error-note" id="nameError"></div>
                </div>
                <div class="form-input mb-3">
                    <input type="text" id="register-email" name="email" class="form-control email"
                           value="{{ old('email') }}"
                           placeholder="{{ trans('web.Email') }}">
                    <label class="form-label" for="register-email">{{ trans('web.Email') }}</label>
                    <div class="error-note" id="emailError"></div>
                </div>
                <div class="form-input mb-3">
                    <input type="text" id="register-phone" name="phone_number" class="form-control phone"
                           value="{{ old('phone_number')}}"
                           placeholder="{{ trans('web.Phone Number') }}">
                    <label class="form-label" for="register-phone">{{ trans('web.Phone Number') }}</label>
                    <div class="error-note" id="phoneError"></div>
                </div>
                <div class="form-input mb-3">
                    <div>
                        <input type="password" id="register-password" name="password"
                               class="form-control password" placeholder="{{ trans('web.Password') }}">
                        <label class="form-label" for="register-password">{{ trans('web.Password') }}</label>
                        <div class="icon password-show"><i class="far fa-eye"></i></div>
                    </div>
                    <div class="error-note" id="passwordError"></div>
                </div>
                <div class="form-input mb-3">
                    <div>
                        <input type="password" id="register-confirm-password" name="password_confirmation"
                               class="form-control password2" placeholder="{{ trans('web.Confirm Password') }}"
                        >
                        <label class="form-label" for="register-password">{{ trans('web.Confirm Password') }}</label>
                        <div class="icon password-show"><i class="far fa-eye"></i></div>
                    </div>
                    <div class="error-note" id="confirmPasswordError"></div>
                </div>
                <div class="mb-3">
                    <div class="validate-input form-check order-2 order-sm-1">
                        <input class="form-check-input checkInput" name="remember" type="checkbox" value="1"
                               id="agree-1">
                        <label class="form-check-label fw-bold" for="flexCheckChecked-1">
                            {{ trans('web.By signing up, I agree with the') }}
                            <a data-bs-toggle="modal" href="#registerTermsModal" role="button"
                               class="text-decoration-underline text-primary">{{ trans('web.Terms of use & Privacy policy') }}</a>
                        </label>
                        <div class="error-note" id="rememberError"></div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-gradiant fw-bold w-100"
                            type="submit">{{ trans('web.Create an account') }}</button>
                </div>
                {{ html()->form()->close() }}
                <div class="divider"><span>OR</span></div>
                <div class="by_gmail text-center mb-3">
                    <a href="{{ route('social.auth-provider', ['provider' => 'google']) }}">
                        <div class="icon">
                            <img src="{{ asset('frontend/assets/images/icons/google.svg') }}" alt="google icon"
                                 loading="lazy">
                        </div>
                        <p class="text-uppercase fw-bold mb-0">{{ trans('web.Log in by gmail') }}</p>
                    </a>
                </div>
                <div class="by_apple text-center mb-3">
                    <a href="{{ route('social.auth-provider', ['provider' => 'apple']) }}">
                        <div class="icon">
                            <img src="{{ asset('frontend/assets/images/icons/apple.svg') }}" alt="apple icon"
                                 loading="lazy">
                        </div>
                        <p class="text-uppercase fw-bold mb-0">{{ trans('web.Log in by Apple') }}</p>
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-dark">{{ trans('web.Already have an account') }} </span>
                    <a data-bs-toggle="modal" href="#loginModal" role="button"
                       class="text-primary fw-bold">{{ trans('web.Login') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>




@guest()
    @if(isset($termsAndConditions))
        <div class="modal registerTermsModal fade" id="registerTermsModal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header justify-content-center border-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                        </button>
                        <h3 class="text-capitalize text-center fw-bold mb-0">{{ $termsAndConditions->{'title_' . app()->getLocale()} }}</h3>
                    </div>
                    <div class="modal-body">
                        <p>{!! $termsAndConditions->{'content_' . app()->getLocale()} !!}</p>
                        <div class="text-center">
                            <a data-bs-toggle="modal" href="#registerModal" role="button" class="text-primary">
                                <i class="fas fa-chevron-left"></i>
                                <span class="ms-3 fw-600">{{ trans('web.Back to create account') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endguest
<div class="modal main-modal forgetPasswordModal fade" id="forgetPasswordModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo mb-2">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                    <h3 class="text-capitalize text-center fw-bold mb-2">{{  trans('web.Forget your Password !')}}</h3>
                    <p class="text-darkGray mb-0 w-75 mx-auto">{{ trans('web.Enter your email address so we can send you a recovery link') }}</p>
                </div>
            </div>
            <div class="modal-body">
                {{ html()->form('post', route('password.forget'))->open() }}
                <div class="form-input mb-3">
                    <input type="email" id="forget-email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('web.Email') }}">
                    <label class="form-label" for="forget-email">{{ trans('web.Email') }}</label>
                    @if($errors->forget_password->has("email"))
                        <div class="error-note">
                            <span class="help-block text-danger">{{ $errors->forget_password->first("email") }}</span>
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <button type="submit"
                            class="btn btn-gradiant fw-bold w-100">{{ trans('web.Send') }}</button>
                </div>
                {{ html()->form()->close() }}
                <div class="text-center">
                    <a data-bs-toggle="modal" href="#loginModal" role="button" class="text-primary">
                        <i class="fas fa-chevron-left"></i>
                        <span class="ms-3 fw-600">{{  trans('web.Back to Login')}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal main-modal checkEmailModal fade" id="checkEmailModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo mb-2">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                    <h3 class="text-capitalize fw-bold mb-2">{{ trans('web.Check your email !') }}</h3>
                    <p class="text-darkGray mb-0 w-75 mx-auto">{{ trans('web.An account recovery email was sent') }}</p>
                </div>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <a data-bs-toggle="modal" href="#loginModal" role="button" class="text-primary">
                        <i class="fas fa-chevron-left"></i>
                        <span class="ms-3 fw-600">{{ trans('web.Back to Login') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($token))
    <div class="modal main-modal resetPasswordModal fade" id="resetPasswordModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header justify-content-center border-0">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                    </button>
                    <div class="text-center">
                        <div class="modal-logo mb-2">
                            <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon"
                                 loading="lazy">
                        </div>
                        <h3 class="text-capitalize text-center fw-bold mb-2">{{  trans('web.Reset Password')}}</h3>
                        <p class="text-darkGray mb-0 w-75 mx-auto">{{  trans('web.Please kindly set your new password')}}</p>
                    </div>
                </div>
                <div class="modal-body">
                    {{  html()->form('post', route('password.reset'))->open() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-input mb-3">
                        <input type="password" id="reset-password" name="password" class="form-control"
                               placeholder="{{ trans('web.Password') }}">
                        <label class="form-label" for="reset-password">{{ trans('web.Password') }}</label>
                        <div class="icon"><i class="far fa-eye"></i></div>
                        @if($errors->resetPassword->has("password"))
                            <div class="error-note">
                                <span
                                    class="help-block text-danger">{{ $errors->resetPassword->first("password") }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="form-input mb-3">
                        <input type="password" id="reset-confirm-password" name="password_confirmation"
                               class="form-control" placeholder="{{ trans('web.Confirm Password') }}">
                        <label class="form-label" for="reset-password">{{  trans('web.Confirm Password') }}</label>
                        <div class="icon"><i class="far fa-eye-slash"></i></div>
                        @if($errors->resetPassword->has("password_confirmation"))
                            <div class="error-note">
                                <span
                                    class="help-block text-danger">{{ $errors->resetPassword->first("password_confirmation") }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-gradiant fw-bold w-100">{{ trans('web.Reset Password') }}</button>
                    </div>
                    {{  html()->form()->close() }}
                    <div class="text-center">
                        <a data-bs-toggle="modal" href="#loginModal" role="button" class="text-primary">
                            <i class="fas fa-chevron-left"></i>
                            <span class="ms-3 fw-600">{{ trans('web.Back to Login') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif




{{--<div class="modal main-modal mapModal fade" id="mapModal" aria-hidden="true" tabindex="-1">--}}
{{--    <div class="modal-dialog modal-xl modal-dialog-centered">--}}
{{--        <div class="modal-content border-0">--}}
{{--            <div class="modal-header justify-content-center border-0 p-0">--}}
{{--                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body p-0">--}}
{{--                --}}{{--                <div id="map_tabs" class="d-flex flex-wrap justify-content-between">--}}
{{--                --}}{{--                    <div class="input-txt">--}}
{{--                --}}{{--                        <span class="icon"><i class="fas fa-search fa-xs"></i></span>--}}
{{--                --}}{{--                        <input type="text" placeholder="Search">--}}
{{--                --}}{{--                    </div>--}}
{{--                --}}{{--                    <div class="active">All</div>--}}
{{--                --}}{{--                    <div>Fella</div>--}}
{{--                --}}{{--                    <div>Lands for sale</div>--}}
{{--                --}}{{--                    <div>shops for rent</div>--}}
{{--                --}}{{--                    <div>Fella</div>--}}
{{--                --}}{{--                    <div>Lands for sale</div>--}}
{{--                --}}{{--                    <div>shops for rent</div>--}}
{{--                --}}{{--                    <div>Fella</div>--}}
{{--                --}}{{--                    <div>Lands for sale</div>--}}
{{--                --}}{{--                </div>--}}
{{--                <div id="map"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="modal main-modal featureMapModal fade" id="featureMapModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0 p-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="map_tabs" class="d-flex flex-wrap justify-content-between">
                    <div class="input-txt">
                        <span class="icon"><i class="fas fa-search fa-xs"></i></span>
                        <input type="text" placeholder="Search">
                    </div>
                    <div class="active">All</div>
                    <div>Fella</div>
                    <div>Lands for sale</div>
                    <div>shops for rent</div>
                    <div>Fella</div>
                    <div>Lands for sale</div>
                    <div>shops for rent</div>
                    <div>Fella</div>
                    <div>Lands for sale</div>
                </div>
                <div id="mapFeature" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal main-modal mapModalLatest fade" id="mapModalLatest" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0 p-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
            </div>
            <div class="modal-body p-0">
                                <div id="map_tabs" class="d-flex flex-wrap justify-content-between">
                                    <div class="input-txt">
                                        <span class="icon"><i class="fas fa-search fa-xs"></i></span>
                                        <input type="text" placeholder="Search">
                                    </div>
                                    <div class="active">All</div>
                                    <div>Fella</div>
                                    <div>Lands for sale</div>
                                    <div>shops for rent</div>
                                    <div>Fella</div>
                                    <div>Lands for sale</div>
                                    <div>shops for rent</div>
                                    <div>Fella</div>
                                    <div>Lands for sale</div>
                                </div>
                <div id="mapLatest" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>





<!-- Modal for Featured Ads Map -->
{{--<div class="modal main-modal featureMapModal fade" id="featureMapModal" aria-hidden="true" tabindex="-1">--}}
{{--    <div class="modal-dialog modal-xl modal-dialog-centered">--}}
{{--        <div class="modal-content border-0">--}}
{{--            <div class="modal-header justify-content-center border-0">--}}
{{--                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div id="mapFeature" style="height: 500px;"></div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Modal for Latest Ads Map -->
{{--<div class="modal main-modal mapModalLatest fade" id="mapModalLatest" aria-hidden="true" tabindex="-1">--}}
{{--    <div class="modal-dialog modal-xl modal-dialog-centered">--}}
{{--        <div class="modal-content border-0">--}}
{{--            <div class="modal-header justify-content-center border-0">--}}
{{--                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div id="mapLatest" style="height: 500px;"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script defer src="https://fastly.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://fastly.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://fastly.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!--Slick Silder-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="{{ asset('frontend/assets/js/validation.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>
{{--<script src="{{ asset('frontend/assets/js/map.js') }}"></script>--}}

<script>
    $(document).ready(function () {
        $('.addProductAction').click(function () {
            var action = $(this).data('action');
            var id = $(this).data('id')
            $.ajax({
                url: '{{ route("web.products.action", ["action" => "REPLACE_ACTION", "id" => "REPLACE_ID"]) }}'
                    .replace('REPLACE_ACTION', action)
                    .replace('REPLACE_ID', id),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.log('AJAX request failed:', error);
                }
            });
        });
    });

    $(document).ready(function () {
        @if(session()->has('login_error'))
        $('#loginModal').modal('show');
        @endif

        @if($errors->register->count())
        $('#registerModal').modal('show');
        @endif
        @if($errors->product_report->count())
        $('#adsReportModal').modal('show');
        @endif

        @if($errors->forget_password->count())
        $('#forgetPasswordModal').modal('show');
        @endif

        @if(session()->has('reset_email_sent'))
        $('#checkEmailModal').modal('show');
        @endif

        @if($errors->resetPassword->count() || isset($token))
        $('#resetPasswordModal').modal('show');
        @endif

        // search in products after typing more than three letters in menuSearchInput input field call ajax and render result
        $("#menuSearchInput").on('keydown', function (event) {
            if (event.key === 'Enter') {
                var value = $(this).val();
                //reset search result
                $(".searchResultList").addClass("d-none");
                $(".searchResultList .search-list").html('');
                $.ajax({
                    type: "get",
                    url: "{{ route('web.search.menu') }}",
                    data: {search: value},
                    success: function (data) {
                        if (data.success) {
                            $(".searchResultNoData").addClass("d-none");
                            $(".searchResultList").removeClass("d-none");
                            $(".searchResultList .search-list").html(data.html);
                        } else {
                            $(".searchResultList").addClass("d-none");
                            $(".searchResultNoData").removeClass("d-none");
                        }
                    }
                });
            }
        });

        // Hide the popup when the ESC key is pressed
        $(document).on('keydown', function (event) {
            if (event.key === 'Escape') {
                $(".searchResultList").addClass("d-none");
                $(".searchResultNoData").addClass("d-none");
            }
        });

    });
</script>


<script>
    // $(document).ready(function() {
    //     // Function to clear error messages on input
    //     function clearErrorMessages() {
    //         $(this).siblings('.error-note').html('');
    //     }
    //
    //     // Attach input event listeners to clear error messages
    //     $('#registerForm input').on('input', clearErrorMessages);
    //
    //     // AJAX form submission
    //     $('#registerForm').on('submit', function(event) {
    //         event.preventDefault();
    //
    //         // Clear previous error messages
    //         $('.error-note').html('');
    //
    //         $.ajax({
    //             url: $(this).attr('action'),
    //             method: $(this).attr('method'),
    //             data: $(this).serialize(),
    //             success: function(response) {
    //                 // Redirect to home on success
    //                 window.location.href = response.redirect;
    //             },
    //             error: function(xhr) {
    //                 // Handle validation errors
    //                 if (xhr.status === 422) {
    //                     var errors = xhr.responseJSON.errors;
    //                     if (errors.name) {
    //                         $('#nameError').html(errors.name[0]);
    //                     }
    //                     if (errors.email) {
    //                         $('#emailError').html(errors.email[0]);
    //                     }
    //                     if (errors.phone_number) {
    //                         $('#phoneError').html(errors.phone_number[0]);
    //                     }
    //                     if (errors.password) {
    //                         $('#passwordError').html(errors.password[0]);
    //                     }
    //                     if (errors.password_confirmation) {
    //                         $('#confirmPasswordError').html(errors.password_confirmation[0]);
    //                     }
    //                     if (errors.remember) {
    //                         $('#rememberError').html(errors.remember[0]);
    //                     }
    //                 } else {
    //                     // Handle general errors
    //                     toastr.error('Something went wrong. Please try again.');
    //                 }
    //             }
    //         });
    //     });
    // });


    $(document).ready(function () {
        $('#registerModal').on('hide.bs.modal', function () {
            $(this).find('form')[0].reset();
            $(this).find('input').val('');
            $(this).find('.error-note').empty();
        });


        // Function to clear error messages on input
        function clearErrorMessages() {
            $(this).closest('.form-input').find('.error-note').html('');
        }

        // Attach input event listeners to clear error messages
        $('#registerForm input').on('input', clearErrorMessages);


        // AJAX form submission
        $('#registerForm').on('submit', function (event) {
            event.preventDefault();

            // Clear previous error messages
            $('.error-note').html('');

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (response) {
                    // Redirect to home on success
                    window.location.href = response.redirect;
                },
                error: function (xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#nameError').html(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#emailError').html(errors.email[0]);
                        }
                        if (errors.phone_number) {
                            $('#phoneError').html(errors.phone_number[0]);
                        }
                        if (errors.password) {
                            $('#passwordError').html(errors.password[0]);
                        }
                        if (errors.password_confirmation) {
                            $('#confirmPasswordError').html(errors.password_confirmation[0]);
                        }
                        if (errors.remember) {
                            $('#rememberError').html(errors.remember[0]);
                        }
                    } else {
                        // Handle general errors
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });

</script>

@yield('script')
@livewireScripts
</body>
</html>

