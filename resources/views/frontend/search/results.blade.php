
@if($properties && $properties->count() > 0)
    <section class="most-viewed searchSection pb-5 pt-2 aos-init aos-animate" data-aos="fade-up"
             data-aos-anchor-placement="top-bottom">
        <div class="container">
            @if($compounds && $compounds->count() >0)
                <h4 class="text-right result py-4">
                    {{ __('main.results includes units in') }}
                    @foreach($compounds_names as $compound)
                        <span class="badge badgeS">{{ $compound }}</span>
                    @endforeach
                </h4>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="properties_search">
                        <div class="row">
                            @foreach($properties as $property)
                                <div class="col-md-6">
                                    <div class="swiper-slide mb-3">
                                        @includeIf('Frontend.components.property_card', ['property' => $property])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4 px-0">
                    <div id="map"></div>
                    <!-- <iframe src="https://maps.google.com/maps?q=Assuit&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%"
                      class="frameMap" frameborder="0" style="border:0" allowfullscreen>
                    </iframe> -->
                </div>
            </div>
        </div>
    </section>
@endif
