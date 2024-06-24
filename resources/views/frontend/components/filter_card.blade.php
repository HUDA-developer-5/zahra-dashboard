{{ html()->form('get', route('web.home'))->class('filterForm')->open() }}
{{ html()->hidden('type', $type)->id($type) }}
<div class="d-flex flex-wrap align-items-center gap-2 filter">

    @if($allCats)
        <div class="sec-select">
            <select class="select2 w-100 form-control" name="category_id">
                <option label="{{ trans('web.Category') }}"> </option>
                @foreach($allCats as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}> {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if($countries->count())
        <div class="sec-select">
            <select class="select2 w-100 form-control" name="country_id">
                <option label="{{ trans('web.Country') }}"> </option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}> {{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="sec-check  @if(request()->has('near_by') && request('near_by') ) checked @endif">
        <span>{{ trans('web.Near by') }}</span>
        <span class="clear"><i class="far fa-circle-xmark"></i></span>
        <input type="hidden" name="near_by" value="{{ request('near_by') }}">
        <input type="hidden" name="latitude" id="latitude_{{$type}}" value="{{ request('latitude') }}">
        <input type="hidden" name="longitude" id="longitude_{{$type}}" value="{{ request('longitude') }}">
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

    <div class="sec-select">
        <select class="select2 w-100 form-control" name="created_at">
            <option value="">-------</option>
            <option value="today" {{ request('created_at') == "today" ? 'selected' : '' }}> {{ trans('web.Today') }}</option>
            <option value="yesterday" {{ request('created_at') == "yesterday" ? 'selected' : '' }}> {{ trans('web.Yesterday') }}</option>
            <option value="week" {{ request('created_at') == "week" ? 'selected' : '' }}> {{ trans('web.7 Days') }}</option>
            <option value="month" {{ request('created_at') == "month" ? 'selected' : '' }}> {{ trans('web.1 Month') }}</option>
            <option value="month_2" {{ request('created_at') == "month_2" ? 'selected' : '' }}> {{ trans('web.2 Month') }}</option>
            <option value="month_3" {{ request('created_at') == "month_3" ? 'selected' : '' }}> {{ trans('web.3 Month') }}</option>
            <option value="month_6" {{ request('created_at') == "month_6" ? 'selected' : '' }}> {{ trans('web.6 month') }}</option>
            <option value="year" {{ request('created_at') == "year" ? 'selected' : '' }}> {{ trans('web.year') }}</option>
        </select>
    </div>
    @auth('users')
        <div>
            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#mapModal" class="map"><i
                        class="far fa-map"></i></a>
        </div>
    @endauth
</div>
{{ html()->form()->close() }}

