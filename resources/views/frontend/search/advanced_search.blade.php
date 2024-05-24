<section class="most-viewed bg-white searchSection pt-5 pb-2 aos-init aos-animate filterSection" data-aos="fade-up"
         data-aos-anchor-placement="top-bottom">
    <div class="container">
        <div class="row pt-5 mt-2 formsControl bg-white">
            <div class="col-xl-2 col-lg-3 col-md-4">
                <div class="form-group form-select">
                    {!! Form::select("property_type", $property_types, request()->get('property_type'), ['class'=>"form-control px-2", "placeholder"=>__('main.property type')]) !!}
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">

                <div class="multiselect mb-3">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select class="form-control">
                            <option>{{ __('main.location') }}</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes" class="pt-2">
                        @if(!empty($locations))
                            @foreach($locations as $key=>$location)
                                <label for="{{ $key }}">
                                    <input @if(in_array($key, request()->get('locations', []))) checked @endif type="checkbox" id="{{ $key }}"/>{{ $location }}
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 pb-3">
                <div class="input-group areaDimentions">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white px-1">{{ __('main.The space') }}</span>
                    </div>
                    <div class="form-group d-inline">
                        <label for="from">{{ __('main.from') }}</label>
                        <input type="text" class="form-control border-0" value="{{ (request()->has('area') && request()->get('area') <= 6) ? \App\Enums\ConstantEnums::AreaSearchValues[request()->get('area', 0)]['from'] : ''  }}">
                    </div>
                    <div class="form-group d-inline">
                        <label for="to">{{ __('main.to') }}</label>
                        <input type="text" class="form-control border-0" value="{{ (request()->has('area') && request()->get('area') <= 6) ? \App\Enums\ConstantEnums::AreaSearchValues[request()->get('area', 0)]['to'] : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">
                <div class="input-group inptGrp mb-3" dir="ltr">
                    <input type="text" class="form-control border-right-0" dir="rtl" value="{{ request()->get('down_payment') }}"
                           aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append border-left-0">
                        <span class="input-group-text bg-white" id="basic-addon2">{{ __('main.Down payment') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">
                <div class="input-group inptGrp mb-3" dir="ltr">
                    <input type="text" class="form-control border-right-0" dir="rtl" value="{{ request()->get('monthly_installment') }}"
                           aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append border-left-0">
                        <span class="input-group-text bg-white" id="basic-addon2">{{ __('main.Monthly installment') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4">
                <p class="pt-2 font-weight-bold advanceSearch"> {{ __('main.advanced search') }}
                    <img src="{{ asset('frontend/assets/imgs/arrowLeft.PNG') }}" width="35"class="arrowAngle" alt="Qorra">
                </p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white alarmMenu newSerchAdv">
    <div class="container text-right py-3">
        {!! Form::open(['method'=>'get', 'route'=>'home search', 'id'=>'AdvancedSearchForm']) !!}
            <div class="row pb-3">
                <div class="col-md-7">
                    <h5 class="newTextColor advSearch font-weight-bold">{{ __('main.advanced search') }} </h5>
                </div>
                <div class="col-md-5 text-left">
                    <button type="reset" class="btn btnDel mx-3"> {{ __('main.clear') }}
                    </button>
                    <button type="submit" class="btn btnApp">{{ __('main.apply') }}</button>
                    <span class="float-left pt-1 closeTime mr-3">
                        <img src="{{ asset('frontend/assets/imgs/close.PNG') }}" alt="Qorra">
                    </span>
                </div>
            </div>
            <div class="row filterOptions pt-3">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">{{ __('main.property type') }}</label>
                        {!! Form::select("property_type", $property_types, request()->get('property_type'), ["id"=>"exampleFormControlSelect1", 'class'=>"form-control px-2", "placeholder"=>__('main.property type')]) !!}
                    </div>
                    <div class="panel-group" id="accordion">
                        <!-- First Panel -->
                        <div class="panel panel-default bg-white rounded">
                            <div class="panel-heading pt-3">
                                <h6 class="panel-title font-weight-bold" data-toggle="collapse"
                                    data-target="#collapseOne">{{ __('main.location') }}</h6>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse show">
                                <div class="panel-body pt-2 pr-0">
                                    @if(!empty($locations))
                                        @foreach($locations as $key=>$location)
                                            <div class="custom-control custom-checkbox mr-sm-2 py-1">
                                                <input name="locations[]" type="checkbox" @if(in_array($key, request()->get('locations', []))) checked @endif value="{{$key}}" class="custom-control-input float-right" id="myCheckBox{{ $key }}">
                                                <label class="custom-control-label" for="myCheckBox{{ $key }}">{{ $location }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>{{ __('main.The space') }}</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {!! Form::text('area_from', request()->get('area_from'), ['class'=>'form-control', 'placeholder'=> __('main.from')]) !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {!! Form::text('area_to', request()->get('area_to'), ['class'=>'form-control', 'placeholder'=> __('main.to')]) !!}
                            </div>
                        </div>
                    </div>
                    <label>{{ __('main.total price') }}</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {!! Form::text('total_price_from', request()->get('total_price_from'), ['class'=>'form-control', 'placeholder'=> __('main.from')]) !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {!! Form::text('total_price_to', request()->get('total_price_to'), ['class'=>'form-control', 'placeholder'=> __('main.to')]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numbRooms">{{ __('main.room counts') }}</label>
                        {!! Form::select("room_count", \App\Enums\ConstantEnums::RoomCountsArray, request()->get('room_count'), ["id"=>"numbRooms", 'class'=>"form-control", "placeholder"=>__('main.room counts')]) !!}
                    </div>
                    <div class="form-group">
                        <label for="tashteeb">{{ __('main.Finishing type') }}</label>
                        {!! Form::select('completion_type', $completion_types, request()->get('completion_type'), ['id'=>'tashteeb', 'class'=>'form-control', "placeholder"=>__('main.Finishing type')]) !!}
                    </div>
                    <div class="form-group">
                        <label for="view">{{ __('main.views') }}</label>
                        {!! Form::select('view_type', $view_types, request()->get('view_type'), ['id'=>'view', 'class'=>'form-control', "placeholder"=>__('main.views')]) !!}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>{{ __('main.I can afford a down payment of') }}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend border-left-0">
                            <span class="input-group-text bg-white" id="basic-addon2">{{ __('main.maximum down payment') }}</span>
                        </div>
                        {!! Form::text('down_payment', request()->get('down_payment'), ['class'=>'form-control border-right-0', 'dir'=>"rtl", "aria-label"=>"Recipient's username", "aria-describedby"=>"basic-addon2", "placeholder"=>" 5000 جم"]) !!}
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="years"> {{ __('main.The number of years of installment') }}</label>
                            {!! Form::number('years_of_installment', request()->get('years_of_installment'), ['id'=>'years', 'min'=>1, 'class'=>'form-control', "placeholder"=>"10"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numbBaths"> {{ __('main.bathroom count') }} </label>
                        {!! Form::select("bathroom_count", \App\Enums\ConstantEnums::BathroomCountsArray, request()->get('bathroom_count'), ["id"=>"numbBaths", 'class'=>"form-control", "placeholder"=>__('main.bathroom count')]) !!}
                    </div>
                    <div class="form-group">
                        <label for="collects"> {{ __('main.compound') }} </label>
                        {!! Form::select("compound_id", $compounds, request()->get('compound_id'), ["id"=>"collects", 'class'=>"form-control", "placeholder"=>__('main.compound')]) !!}
                    </div>
                    <div class="form-group">
                        <label for="morfqat"> {{ __('main.facilities') }} </label>
                        {!! Form::select("facility_id", $facilities, request()->get('facility_id'), ["id"=>"morfqat", 'class'=>"form-control", "placeholder"=>__('main.facilities')]) !!}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>{{ __('main.Installments that I can pay monthly') }}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend border-left-0">
                            <span class="input-group-text bg-white" id="basic-addon2">{{ __('main.maximum down payment') }}</span>
                        </div>
                        {!! Form::text('monthly_installment', request()->get('monthly_installment'), ['class'=>'form-control border-right-0', 'dir'=>"rtl", "aria-label"=>"Recipient's username", "aria-describedby"=>"basic-addon2", "placeholder"=>" 5000 جم"]) !!}
                    </div>
                    <div class="form-group">
                        <label for="deadTime"> {{ __('main.delivery year') }} </label>
                        <input type="text" id="deadTime" class="form-control" name="delivery_year"
                               value="01/01/2021 - 01/15/2030"/>
                    </div>
                    <div class="form-group">
                        <label for="floorN"> {{ __('main.floor') }} </label>
                        {!! Form::select("floor", $floors, request()->get('floor'), ["id"=>"floorN", 'class'=>"form-control", "placeholder"=>__('main.floor')]) !!}
                    </div>
                    <div class="form-group">
                        <label for="developer"> {{ __('main.developer') }} </label>
                        {!! Form::select("developer_id", $developers, request()->get('developer_id'), ["id"=>"developer", 'class'=>"form-control", "placeholder"=>__('main.floor')]) !!}
                    </div>
                </div>
            </div>
            <input type="hidden" name="sort_by_price" id="sort_by_price">
            <input type="hidden" name="sort_by_date" id="sort_by_date">
            <input type="hidden" name="search_results" id="saveSearchResult">
        {!! Form::close() !!}
    </div>
</section>
