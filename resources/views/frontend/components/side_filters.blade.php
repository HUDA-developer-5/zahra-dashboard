<div class="col-lg-3">
    {{ html()->form('get', route('web.products.search'))->id('filterForm')->open() }}

    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}" id="SortByInput">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <h6 class="fw-bold mb-0">{{ trans('web.Filters') }}</h6>
        <a href="{{ route('web.products.search') }}" class="text-primary fs-7 fw-bold mb-0">{{ trans('web.Clear All') }}</a>
    </div>
    <div class="card filters mb-3">
        <div class="accordion" id="filterCategoryAccordion">
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#CategoryCollapse" aria-expanded="true" aria-controls="CategoryCollapse">
                        {{ trans('web.All Category') }}
                    </button>
                </h2>
            </div>
{{--            <div id="CategoryCollapse" class="accordion-collapse collapse show" aria-labelledby="headingOne">--}}
{{--                <div class="search-input mb-2">--}}
{{--                    <input type="text" name="search"  value="{{ request('search') }}" id="filter-search" class="form-control"--}}
{{--                           placeholder="{{ trans('web.Search') }}">--}}
{{--                    <span class="icon"><i class="fas fa-magnifying-glass"></i></span>--}}
{{--                </div>--}}
{{--                <ul class="list">--}}
{{--                    @foreach($menuCategories as $menuCategory)--}}
{{--                        <li class="form-check @if($menuCategory->child?->count()) sub-types @endif">--}}
{{--                            <input name="categories_id[]" class="form-check-input" type="checkbox"--}}
{{--                                   value="{{ $menuCategory->id }}" id="flexCheckChecked{{ $menuCategory->id }}" {{ in_array($menuCategory->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                            <label class="form-check-label"--}}
{{--                                   for="flexCheckChecked_{{ $menuCategory->id }}">{{ $menuCategory->name }}</label>--}}
{{--                            @if($menuCategory->child?->count())--}}
{{--                                @foreach($menuCategory->child as $firstChild)--}}
{{--                                    <ul>--}}
{{--                                        <li class="form-check @if($firstChild->child?->count()) sub-types @endif">--}}
{{--                                            <input name="categories_id[]" class="form-check-input" type="checkbox"--}}
{{--                                                   value="{{$firstChild->id}}"--}}
{{--                                                   id="flexCheckChecked_{{$firstChild->id}}" {{ in_array($firstChild->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                                            <label class="form-check-label"--}}
{{--                                                   for="flexCheckChecked_{{$firstChild->id}}">{{ $firstChild->name }}</label>--}}

{{--                                            @if($firstChild->child?->count())--}}
{{--                                                @foreach($firstChild->child as $secondChild)--}}
{{--                                                    <ul>--}}
{{--                                                        <li class="form-check ">--}}
{{--                                                            <input name="categories_id[]" class="form-check-input"--}}
{{--                                                                   type="checkbox" value="{{$secondChild->id}}"--}}
{{--                                                                   id="flexCheckChecked_{{$secondChild->id}}" {{ in_array($secondChild->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                                                            <label class="form-check-label"--}}
{{--                                                                   for="flexCheckChecked_{{$secondChild->id}}">{{ $secondChild->name }}</label>--}}

{{--                                                            @if($secondChild->child?->count())--}}
{{--                                                                @foreach($secondChild->child as $thirdChild)--}}
{{--                                                                    <ul>--}}
{{--                                                                        <li class="form-check ">--}}
{{--                                                                            <input name="categories_id[]" class="form-check-input"--}}
{{--                                                                                   type="checkbox" value="{{$thirdChild->id}}"--}}
{{--                                                                                   id="flexCheckChecked_{{$thirdChild->id}}" {{ in_array($thirdChild->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                                                                            <label class="form-check-label"--}}
{{--                                                                                   for="flexCheckChecked_{{$thirdChild->id}}">{{ $thirdChild->name }}</label>--}}

{{--                                                                            @if($thirdChild->child?->count())--}}
{{--                                                                                @foreach($thirdChild->child as $fourthChild)--}}
{{--                                                                                    <ul>--}}
{{--                                                                                        <li class="form-check ">--}}
{{--                                                                                            <input name="categories_id[]" class="form-check-input"--}}
{{--                                                                                                   type="checkbox" value="{{$fourthChild->id}}"--}}
{{--                                                                                                   id="flexCheckChecked_{{$fourthChild->id}}" {{ in_array($fourthChild->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                                                                                            <label class="form-check-label"--}}
{{--                                                                                                   for="flexCheckChecked_{{$fourthChild->id}}">{{ $fourthChild->name }}</label>--}}
{{--                                                                                        </li>--}}
{{--                                                                                    </ul>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            @endif--}}
{{--                                                                        </li>--}}
{{--                                                                    </ul>--}}
{{--                                                                @endforeach--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}


{{--            <div class="accordion-collapse collapse show" aria-labelledby="headingOne">--}}
{{--                <div class="search-input mb-2">--}}
{{--                    <input type="text" name="search" value="{{ request('search') }}" id="filter-search" class="form-control"--}}
{{--                           placeholder="{{ trans('web.Search') }}">--}}
{{--                    <span class="icon"><i class="fas fa-magnifying-glass"></i></span>--}}
{{--                </div>--}}
{{--                <ul class="list" id="category-list">--}}
{{--                    @foreach($menuCategories as $menuCategory)--}}
{{--                        <li class="form-check @if($menuCategory->child?->count()) sub-types @endif">--}}
{{--                            <input name="categories_id[]" class="form-check-input" type="checkbox"--}}
{{--                                   value="{{ $menuCategory->id }}" id="flexCheckChecked{{ $menuCategory->id }}" {{ in_array($menuCategory->id, request('categories_id', [])) ? 'checked' : '' }}>--}}
{{--                            <label class="form-check-label"--}}
{{--                                   for="flexCheckChecked_{{ $menuCategory->id }}">{{ $menuCategory->name }}</label>--}}
{{--                            <!-- Include nested categories here as needed -->--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}


            <div id="CategoryCollapse" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                <div class="search-input mb-2">
                    <input type="text" name="search" value="{{ request('search') }}" id="filter-search" class="form-control"
                           placeholder="{{ trans('web.Search') }}">
                    <span class="icon"><i class="fas fa-magnifying-glass"></i></span>
                </div>
                <ul class="list" id="category-list">
                    @include('frontend.render.category_list', ['categories' => $menuCategories])
                </ul>
            </div>


        </div>
    </div>
    <div class="card filters mb-3">
        <div class="accordion" id="filterCountryAccordion">
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#CountryCollapse" aria-expanded="true" aria-controls="CountryCollapse">
                        {{ trans('web.Country') }}
                    </button>
                </h2>
            </div>
            <div id="CountryCollapse" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                @if(isset($countries))
                    <select class="select2 w-100 form-control" name="country_id">
                        <option label="{{ trans('web.Country') }}"> </option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}> {{ $country->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>
    <div class="card filters mb-3">
        <div class="accordion" id="filterTypeAccordion">
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#TypeCollapse" aria-expanded="true" aria-controls="TypeCollapse">
                        {{ trans('web.Type') }}
                    </button>
                </h2>
            </div>
            <div id="TypeCollapse" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                <div class="d-flex flex-wrap gap-1">
                    <div class="sec-check  @if(request()->has('near_by') && request('near_by') ) checked @endif">
                        <span>{{ trans('web.Near by') }}</span>
                        <span class="clear"><i class="far fa-circle-xmark"></i></span>
                        <input type="hidden" name="near_by" value="{{ request('near_by') }}">
                        <input type="hidden" name="latitude" id="latitude" value="{{ request('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ request('longitude') }}">
                    </div>
                    <div class="sec-check  @if(request()->has('available_photo') && request('available_photo') ) checked @endif">
                        <span>{{ trans('web.Available photo') }}</span>
                        <span class="clear"><i class="far fa-circle-xmark"></i></span>
                        <input type="hidden" name="available_photo" value="{{ request('available_photo') }}">
                    </div>
                    <div class="sec-check  @if(request()->has('most_viewed') && request('most_viewed') ) checked @endif">
                        <span>{{ trans('web.Most viewed') }}</span>
                        <span class="clear"><i class="far fa-circle-xmark"></i></span>
                        <input type="hidden" name="most_viewed" value="{{ request('most_viewed') }}">
                    </div>
                    <div class="sec-check @if(request()->has('non_negotiable') && request('non_negotiable') ) checked @endif">
                        <span>{{ trans('web.Non-Negotiable') }}</span>
                        <span class="clear"><i class="far fa-circle-xmark"></i></span>
                        <input type="hidden" name="non_negotiable" value="{{ request('non_negotiable') }}">
                    </div>
                    <div class="sec-check  @if(request()->has('negotiable') && request('negotiable') ) checked @endif">
                        <span>{{ trans('web.Negotiable') }}</span>
                        <span class="clear"><i class="far fa-circle-xmark"></i></span>
                        <input type="hidden" name="negotiable" value="{{ request('negotiable') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card filters mb-3">
        <div class="accordion" id="filterPriceAccordion">
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#PriceCollapse" aria-expanded="true" aria-controls="PriceCollapse">
                        {{ trans('web.Price') }}
                    </button>
                </h2>
            </div>
            <div id="PriceCollapse" class="accordion-collapse collapse show" aria-labelledby="headingFour">
                <div class="price-input d-flex flex-wrap mb-3">
                    <div class="form-input">
                        <input type="text" id="from" name="price_from" class="form-control" placeholder="{{ trans('web.From') }}" value="{{ $maxPrice }}">
                        <label class="form-label" for="from">{{ trans('web.From') }}</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="to" name="price_to" class="form-control" placeholder="{{ trans('web.To') }}" value="{{ $minPrice }}">
                        <label class="form-label" for="to">{{ trans('web.To') }}</label>
                    </div>
                </div>
                <div class="slider">
                    <div class="progress"></div>
                </div>
                <div class="range-input">
                    <input type="range" class="range-min" min="0" max="10000" value="2500" step="100" id="rangeMin">
                    <input type="range" class="range-max" min="0" max="10000" value="7500" step="100" id="rangeMax">
                </div>
                <input type="hidden" name="price_from" id="priceFrom" value="">
                <input type="hidden" name="price_to" id="priceTo" value="">
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>

