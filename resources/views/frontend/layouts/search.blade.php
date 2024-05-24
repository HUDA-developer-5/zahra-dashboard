<div class="col-xl-4 col-lg-3 search">
    <div class="input-txt">
        <span class="icon"><i class="fas fa-search fa-xs"></i></span>
        {{ html()->text('search')->id("menuSearchInput")->placeholder(trans('web.Search')) }}
    </div>

    <div class="search-data d-none searchResultList">
        <div class="search-list">
            <h6 class="text-darkGray">{{ trans('web.Resent Item') }}</h6>
        </div>
    </div>
    <div class="search-data d-none searchResultNoData">
        <div class="no-data h-100">
            <div class="img">
                <img src="{{ asset('frontend/assets/images/no-data.png') }}" alt="nodata image" loading="lazy">
            </div>
            <h3>{{ trans('web.No Result Found') }}</h3>
            <p>{{ trans("web.Its Seems we can't find any results based on your search") }}</p>
        </div>
    </div>
</div>
