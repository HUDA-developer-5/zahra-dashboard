<div class="sub-category">
    <div class="owl-carousel sub-category-carousel">
        @if($subCategories->count())
            @foreach($subCategories as $subCategory)
                <div class="item" wire:key="{{ $subCategory->id }}">
                    <div class="category {{ ($loop->first) ? "active" : "" }} text-center">
                        <div class="img mb-2">
                            <img src="{{ $subCategory->image_path }}" alt="{{ $subCategory->name }}"
                                 class="img-fluid"
                                 loading="lazy">
                        </div>
                        <h6 class="name">{{ $subCategory->name }}</h6>
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
