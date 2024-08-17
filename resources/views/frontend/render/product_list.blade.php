<div class="ads-list-sec">
    <div class="row" id="products-list">
        @if($products && $products->count())
            @foreach($products as $product)
                <div class="col-xl-4 col-md-6 mb-3">
                    @include('frontend.components.product_card', ['product' => $product])
                </div>
            @endforeach
        @else
            <p>{{ __('No products found') }}</p>
        @endif
    </div>
</div>
