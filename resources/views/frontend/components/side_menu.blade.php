<div class="col-lg-3 mb-lg-0 mb-3">
    <div class="profile-side bg-white">
        <h5 class="fw-bold">{{ trans('web.Account Settings') }}</h5>
        <ul>
            <li class="info">
                <a href="{{ route('profile') }}" class=" @if(Route::is("profile"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/profile-circle.svg') }}" alt="profile image">
                    <span class="ms-1">{{ trans('web.Personal Info') }}</span>
                </a>
            </li>

            <li class="wallet">
                <a href="{{ route('wallet') }}" class=" @if(Route::is("wallet"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/wallet-dark.svg') }}"
                         alt="wallet image">
                    <span class="ms-1">{{ trans('web.Wallet') }}</span>
                </a>
            </li>

            <li class="my-commissions">
                <a href="{{ route('web.my-commissions.list') }}" class=" @if(Route::is("web.my-commissions.list"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/percentage-circle.svg') }}"
                         alt="percentage image">
                    <span class="ms-1">{{ trans('web.My Commissions') }}</span>
                </a>
            </li>

            <li class="my-cards">
                <a href="{{ route('web.my-cards.list') }}" class=" @if(Route::is("web.my-cards.list"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/heart-dark.svg') }}"
                         alt="heart image">
                    <span class="ms-1">{{ trans('web.My Cards') }}</span>
                </a>
            </li>
            <li class="my-ads">
                <a href="{{ route('web.my-products.list') }}" class=" @if(Route::is("web.my-products.list"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/box-add.svg') }}"
                         alt="box image">
                    <span class="ms-1">{{ trans('web.My Ads') }}</span>
                </a>
            </li>

            <li class="favorite" >
                <a href="{{ route('web.favourite.list') }}" class=" @if(Route::is("web.favourite.list"))) active @endif">
                    <img src="{{ asset('frontend/assets/images/icons/heart-dark.svg') }}"
                         alt="heart image">
                    <span class="ms-1">{{ trans('web.My Favorite') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>