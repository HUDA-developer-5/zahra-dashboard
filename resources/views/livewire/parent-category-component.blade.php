<div class="categories-list">
    <div class="owl-carousel categories-carousel">
        @foreach($componentParentCategories as $componentParentCategory)
            <a href="#" wire:click="showSubcategories({{ $componentParentCategory->id }})"
               wire:key="{{ $componentParentCategory->id }}">
                <div class="item">
                    <div class="category text-center {{ ($loop->first) ? "active" : "" }}">
                        <div class="img mb-2">
                            <img src="{{ $componentParentCategory->image_path }}" alt="{{ $componentParentCategory->name }}"
                                 class="img-fluid"
                                 loading="lazy">
                        </div>
                        <h6 class="name">{{ $componentParentCategory->name }}</h6>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="sub-category">
        <div class="owl-carousel sub-category-carousel">
            @if($componentSubCategories->count())
                @foreach($componentSubCategories as $componentSubCategory)
                    <div class="item" wire:key="{{ $componentSubCategory->id }}">
                        <div class="category {{ ($loop->first) ? "active" : "" }} text-center">
                            <div class="img mb-2">
                                <img src="{{ $componentSubCategory->image_path }}" alt="{{ $componentSubCategory->name }}"
                                     class="img-fluid"
                                     loading="lazy">
                            </div>
                            <h6 class="name">{{ $componentSubCategory->name }}</h6>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="subcategory">
                    <h6 class="name">No subcategories found.</h6>
                </div>
            @endif

        </div>
    </div>
    <div class="text-center mt-4 d-none d-lg-block">
        <a href="{{ route('web.categories') }}"
           class="text-primary fw-bold">{{ trans('web.View More') }}</a>
    </div>
</div>