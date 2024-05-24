@if($saved_search_results && $saved_search_results->count() > 0)
    <section class="bg-white alarmMenu willHide notifications">
        <div class="container text-right py-3">
            <h5 class="newTextColor font-weight-bold">{{ __('main.Notification lists') }}
                <span class="float-left closeNotificationsH">
                    <img src="{{ asset('frontend/assets/imgs/close.PNG') }}" alt="Qorra">
                </span>
            </h5>
        </div>
    </section>

    <section class="most-viewed mt-2 aos-init aos-animate willHide bg-white" data-aos="fade-up"
             data-aos-anchor-placement="top-bottom">
        <div class="container">
            <div class="row justify-content-between pb-4">
                <div class="pagination-container col-12">
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev">
                        <img src="{{ asset('frontend/assets/imgs/home/icon-arrow-left.svg') }}" width="17px"
                             alt="Qorra"/>
                    </div>
                    <div class="swiper-button-next">
                        <img src="{{ asset('frontend/assets/imgs/home/icon-arrow-right.svg') }}" width="17px"
                             alt="Qorra"/>
                    </div>
                </div>
            </div>
            <!-- Swiper -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($saved_search_results as $saved_search_result)
                        @if(!$saved_search_result->property)
                            @continue
                        @endif
                        <div class="swiper-slide">
                            <div class="pr-4 pl-4 alarmBox">
                                <div class="info d-flex py-2">
                                    <div class="w-100">
                                        <p class="font-weight-bold text-right mb-0 mt-2 pb-1">
                                            <a href="#" class="text-dark">{{ ($saved_search_result->property) ? $saved_search_result->property->name : '' }}</a>
                                            <span class="float-left mt-1">
                                                <a href="{{ url()->route('delete saved search property', ['id' => $saved_search_result->saved_search_result_id]) }}">
                                                    <img src="{{ asset('frontend/assets/imgs/delete.svg') }}" alt="Qorra">
                                                </a>
                                            </span>
                                        </p>
                                        <small class="text-right d-block">
                                            {{ ($saved_search_result->property) ? $saved_search_result->property->area .' '.__('main.meter').',' : '' }}
                                            {{ ($saved_search_result->property->installments && $saved_search_result->property->installments->first()) ? __('main.installment') .', '. $saved_search_result->property->installments->first()->pay_monthly .' '.__('main.monthly') : '' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
