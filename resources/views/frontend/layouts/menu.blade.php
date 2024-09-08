<header class="main-header">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-sm-between justify-content-center align-items-center gap-2">
            <div class="logo">
                <div class="img">
                    <a href="{{ route('web.home') }}"><img src="{{ asset('frontend/assets/images/logo.png') }}"
                                                           alt="logo image" loading="lazy"></a>
                </div>
            </div>

            @include('frontend.layouts.search')

            <div id="menu">
                <ul class="list-unstyled d-flex mb-0">
                    <li>
                        <a href="{{ url()->route('web.home') }}"
                           class="@if(Route::is("web.home")) active @endif">{{ trans('web.Home') }}</a>
                    </li>
                    @if($menuCategories && $menuCategories->count())
                        <li class="all-category">
                            <a href="{{ route('web.categories') }}">{{ trans('web.Category') }}</a>
                            <div class="justify-content-between">
                                <ul class="sub-category">
                                    @foreach($menuCategories as $menuCategory)
                                        <li class="active">
{{--                                            route('web.show_category', ['id' => $menuCategory->id])--}}
                                            <a href="{{  url()->route('web.categories').'?category_id='.$menuCategory->id }}"
                                               class="d-flex justify-content-between"><span>{{ $menuCategory->name }}</span><span
                                                        class="icon"><i class="fas fa-chevron-right"></i></span></a>
                                            @if($menuCategory->child?->count())
                                                <ul class="sub-category">
                                                    @foreach($menuCategory->child as $firstChild)
                                                        <li>
{{--                                                            href="{{ route('web.show_category', ['id' => $firstChild->id]) }}"--}}
                                                            <a href="{{  url()->route('web.categories').'?category_id='.$menuCategory->id }}"
                                                               class="d-flex justify-content-between"><span>{{ $firstChild->name }}</span><span
                                                                        class="icon"><i
                                                                            class="fas fa-chevron-right"></i></span></a>
                                                            @if($firstChild->child?->count())
                                                                <ul class="sub-category">
                                                                    @foreach($firstChild->child as $secondChild)
                                                                        <li>
{{--                                                                            href="{{ route('web.show_category', ['id' => $secondChild->id]) }}"--}}
                                                                            <a href="{{ url()->route('web.categories').'?category_id='.$menuCategory->id }}"
                                                                               class="d-flex justify-content-between"><span>{{ $secondChild->name }}</span><span
                                                                                        class="icon"><i
                                                                                            class="fas fa-chevron-right"></i></span></a>
                                                                            @if($secondChild->child?->count())
                                                                                <ul class="sub-category">
                                                                                    @foreach($secondChild->child as $thirdChild)
                                                                                        <li>
{{--                                                                                            href="{{ route('web.show_category', ['id' => $thirdChild->id]) }}"--}}
                                                                                            <a href="{{  url()->route('web.categories').'?category_id='.$menuCategory->id }}"
                                                                                               class="d-flex justify-content-between"><span>{{ $thirdChild->name }}</span></a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('web.categories') }}"
                                   class="text-primary see-more"><span>{{ trans('web.Show All') }}</span><span
                                            class="icon ms-3"><i class="fas fa-chevron-right"></i></span></a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="top-options d-flex align-items-center justify-content-center">
                <div class="lang">
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#preferenceModal">
                        <i class="fas fa-globe"></i>
                        <span>{{ \Illuminate\Support\Str::ucfirst(LaravelLocalization::getCurrentLocale()) }}</span>
                        <i class="fas fa-chevron-down fa-xs"></i>
                    </a>
                </div>

                @if(!auth('users')->check())
                    <div class="before-login"> <!-- add class="d-none" after login -->
                        <div class="sign-in">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#loginModal"
                               class="btn btn-gradiant btn-login">
                                <i class="fas fa-arrow-right-to-bracket me-1"></i>
                                <span>{{ trans('web.Login') }}</span>
                            </a>
                        </div>
                    </div>
                @endif

                @if(auth('users')->check())
                    <div class="after-login">
                        <!-- remove class="d-none" after login -->
                        <div class="d-flex align-items-center menu-list">
                            <div class="notifications">
                                <a href="#">
                                    <span class="me-1"><img
                                                src="{{ asset('frontend/assets/images/icons/notification.svg') }}"
                                                alt="notification icon" loading="lazy"></span>
                                    <span class="count">{{ auth('users')->user()->unreadNotifications->count() }}</span>
                                </a>
                                <div class="arrow"></div>
                                <div class="dropdown">
                                    <p class="text-dark fw-bold my-2"> {{ trans('web.Notifications') }}</p>
                                    <ul>
                                        @foreach(auth('users')->user()->unreadNotifications()->take(30)->get() as $notification)
                                            <li>
                                                <div class="d-flex align-items-start gap-2">
                                                    <img src="{{  ($notification->targetUser?->image)? $notification->targetUser?->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                                         alt="profile-img" loading="lazy">
                                                    <div>
                                                        <span>{{ \Illuminate\Support\Str::limit($notification->{"content_".app()->getLocale()}, 110) }}</span>
                                                        @if($notification->action == \App\Enums\NotificationActionEnums::NotifyAdsOwnerWithOpenOffer->value)
                                                            <a href="{{ route('web.chats.list', ['notification_id' => $notification->id]) }}"
                                                               class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                                                        @else
                                                            <a href="{{ route('web.products.show', ['id' => $notification->payload['advertisement_id'], 'notification'=> $notification->id]) }}"
                                                               class="text-primary fw-bold">{{ trans('web.View Comment') }}</a>
                                                            <p class="date fs-7 text-gray">{{ $notification->created_at->format('d/m/Y') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center pt-2">
                                        <a href="{{ route('web.notifications.list') }}"
                                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="messages">
                                <a href="#">
                                    <span class="me-1">
                                        <img src="{{ asset('frontend/assets/images/icons/messages.svg') }}"
                                             alt="messages icon" loading="lazy">
                                    </span>
                                    <span class="count"> {{ (auth('users')->check()) ? (new \App\Services\ChatMessageService())->getUserUnreadMessagesCount(auth('users')->id()) : 0   }}</span>
                                </a>
                                <div class="arrow"></div>
                                <div class="dropdown">
                                    <p class="text-dark fw-bold my-2"> {{ trans('web.Messages')}} </p>
                                    <ul>
                                        @auth('users')
                                            @foreach(auth('users')->user()->chats()->with(['messages', 'unReadMessages' => function ($builder) {
                                                    $builder->where('receiver_id', '=', auth('users')->user()->id);
                                                }])->orderBy('id', 'desc')->take(10)->get() as $chat)
                                                <li>
                                                    <div class="d-flex align-items-start gap-2">
                                                        <img src="{{ $chat->sender_avatar }}"
                                                             alt="profile-img" loading="lazy">
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="mb-0">{{ $chat->sender_name  }}</h6>
                                                                @if($chat->unReadMessages->count() >0)
                                                                    <span class="num">{{ $chat->unReadMessages->count() }}</span>
                                                                @endif
                                                            </div>
                                                            <p class="text-gray">{{ \Illuminate\Support\Str::limit($chat->messages?->last()?->message, 120) }}</p>
                                                            <p class="date fs-7 text-gray">{{ $chat->messages?->last()?->created_at->format('h:i a') }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endauth
                                    </ul>
                                    <div class="text-center pt-2">
                                        <a href="{{ route('web.chats.list') }}"
                                           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist">
                                <a href="{{ route('web.favourite.list') }}">
                                    <span class="me-1">
                                        <img src="{{ asset('frontend/assets/images/icons/heart.svg') }}"
                                             alt="wishlist icon" loading="lazy">
                                    </span>
                                </a>
                            </div>

                            <div class="account">
                                <a href="javascript:void(0)">
                                <span class="me-1">
                                    <img src="{{  (auth('users')->user()->image)? auth('users')->user()->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                         alt="profile-img" loading="lazy">
                                </span>
                                    <span class="icon"><i class="fas fa-bars"></i></span>
                                </a>
                                <div class="arrow"></div>
                                <div class="dropdown">
                                    <div class="d-flex align-items-start details gap-2">
                                        <img src="{{  (auth('users')->user()->image)? auth('users')->user()->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                             alt="profile image">
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ auth('users')->user()->name }}</h6>
                                            <p class="fs-7 text-darkGray mb-0">{{ trans('web.My account') }}</p>
                                        </div>
                                    </div>
                                    <ul>
                                        <li class="info">
                                            <a href="{{ route('profile') }}" class="active">
                                                <img src="{{ asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                                     alt="profile image">
                                                <span class="ms-1">{{ trans('web.Personal Info') }}</span>
                                            </a>
                                        </li>
                                        <li class="wallet">
                                            <a href="{{ route('wallet') }}">
                                                <img src="{{ asset('frontend/assets/images/icons/wallet-dark.svg') }}"
                                                     alt="wallet image">
                                                <span class="ms-1">{{ trans('web.Wallet') }}</span>
                                            </a>
                                        </li>
                                        <li class="my-commissions">
                                            <a href="{{ route('web.my-commissions.list') }}">
                                                <img src="{{ asset('frontend/assets/images/icons/percentage-circle.svg') }}"
                                                     alt="percentage image">
                                                <span class="ms-1">{{ trans('web.My Commissions') }}</span>
                                            </a>
                                        </li>
                                        <li class="my-cards">
                                            <a href="{{ route('web.my-cards.list') }}">
                                                <img src="{{ asset('frontend/assets/images/icons/heart-dark.svg') }}"
                                                     alt="heart image">
                                                <span class="ms-1">{{ trans('web.My Cards') }}</span>
                                            </a>
                                        </li>
                                        <li class="my-ads">
                                            <a href="{{ route('web.my-products.list') }}">
                                                <img src="{{ asset('frontend/assets/images/icons/box-add.svg') }}"
                                                     alt="box image">
                                                <span class="ms-1">{{ trans('web.My Ads') }}</span>
                                            </a>
                                        </li>
                                        <li class="logot">
                                            <a href=" {{ route('web.logout') }}" class="text-primary">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                <span class="ms-1">{{ trans('web.Logout') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="share-ad">
                    @auth('users')
                        <a href="{{ route('web.products.add') }}" class="btn btn-share">
                            <span class="icon"><i class="far fa-plus"></i></span>
                            <span class="d-none d-sm-inline">{{ trans('web.Share your ads') }}</span>
                        </a>
                    @else
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#loginModal"
                           class="btn btn-share">
                            <span class="icon"><i class="far fa-plus"></i></span>
                            <span class="d-none d-sm-inline">{{ trans('web.Share your ads') }}</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</header>
