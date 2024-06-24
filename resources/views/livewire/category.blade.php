<div>
    <div id="categories" class="py-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="title fw-bold">{{ trans('web.Categories') }}</h2>
                <div class="d-lg-none d-block">
                    <a href="{{ route('web.categories') }}"
                       class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                </div>
            </div>
            <div class="categories-list">
                <div class="owl-carousel categories-carousel">
                    @if(count($homeParentCategories))
                        @foreach($homeParentCategories as $parentCategory)
                            <div class="item" wire:click="toggleSubCategories('{{ $parentCategory->id }}')">
                                <div class="category text-center {{ ($selectedParentCategory == $parentCategory->id) ? "active" : "" }}">
                                    <div class="img mb-2">
                                        <a href="javascript:void(0)">
                                            <img src="{{ $parentCategory->image_path }}"
                                                 alt="{{ $parentCategory->name }}" class="img-fluid" loading="lazy">
                                        </a>
                                    </div>
                                    <h6 class="name">{{ $parentCategory->name }}</h6>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="sub-category">
                    <div class="owl-carousel sub-category-carousel">
                        @if(count($subCategories))
                            @foreach($subCategories as $subCategory)
                                <div class="item">
                                    <div class="category text-center">
                                        <div class="img mb-2">
                                            <img src="{{ $subCategory->image_path }}" alt="{{ $subCategory->name }}"
                                                 class="img-fluid"
                                                 loading="lazy">
                                        </div>
                                        <h6 class="name">{{ $subCategory->name }}</h6>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="text-center mt-4 d-none d-lg-block">
                    <a href="{{ route('web.categories') }}"
                       class="text-primary fw-bold">{{ trans('web.View More') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        let rtlVal = $('body').attr('dir') == 'rtl' ? true : false;
        function initOwlCarousels() {
            console.log('Initializing Owl Carousels');
            $(".categories-carousel, .sub-category-carousel").owlCarousel({
                rtl: rtlVal,
                dots: false,
                nav: false,
                autoplay: true,
                autoplayHoverPause: true,
                loop: false,
                margin: 10,
                responsive: {
                    0: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    },
                    1200: {
                        items: 8,
                    },
                    1400: {
                        items: 12,
                    },
                },
            });
        }

        function destroyOwlCarousels() {
            console.log('Destroying Owl Carousels');
            var categoriesCarousel = $('.categories-carousel');
            if (categoriesCarousel.hasClass('owl-loaded')) {
                categoriesCarousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
                categoriesCarousel.find('.owl-stage-outer').children().unwrap();
            }

            var subCategoryCarousel = $('.sub-category-carousel');
            if (subCategoryCarousel.hasClass('owl-loaded')) {
                subCategoryCarousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
                subCategoryCarousel.find('.owl-stage-outer').children().unwrap();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOMContentLoaded');
            initOwlCarousels();
        });

        document.addEventListener('livewire:load', function () {
            console.log('Livewire loaded');
            Livewire.hook('message.sent', (message, component) => {
                console.log('Message sent');
                destroyOwlCarousels();
                initOwlCarousels();
            });

            Livewire.on('categoriesUpdated', () => {
                console.log('Categories updated');
                destroyOwlCarousels();
                initOwlCarousels();
            });
        });
    </script>
@endsection
