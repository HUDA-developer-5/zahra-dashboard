@if(!empty($product))
    <div class="card">
        <div class="img">
            <img src="{{ $product->image_path }}" alt="{{ $product->name }}"
                 class="w-100"
                 loading="lazy">
        </div>
        <div class="d-flex align-items-center justify-content-between top-card">
            <div class="d-flex gap-2">
                @includeIf("frontend.components.fav_icon", ["isFav" => $product->is_favourite, "product_id"=>$product->id])
                <div class="best {{ (!$product->is_premium) ? "d-none" : "" }}">
                    <img src="{{ asset('frontend/assets/images/icons/crown.svg') }}"
                         alt="crown icon"
                         loading="lazy">
                </div>
            </div>
            @if($product->is_negotiable)
                <div class="negotiable">{{ trans('web.Negotiable') }}</div>
            @endif
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between fs-7 mb-2">
                <span class="cat text-secondary"># {{ $product->category?->name }}</span>
                <span> {{ $product->created_at->format('Y/m/d') }}</span>
            </div>
            <h5 class="title"><a href="{{ route('web.products.show', ['id'=>$product->id]) }}">{{ $product->name }}</a>
            </h5>
            <div class="location mb-2">
                <span class="icon me-2"><i class="fas fa-location-dot"></i></span>
                <span>{{ $product->nationality?->name }} {{ $product->nationality?->city?->name }}</span>
            </div>
            <p class="price text-primary fw-bold fs-5 mb-2">{{ $product->default_price }} {{ trans('web.'.$product->currency) }}</p>
            <div class="btns">
                <a href="javascript:void(0);" data-bs-toggle="modal"
                   data-bs-target="#beforeLoginModal"
                   class="btn btn-gradiant btn-chat addProductAction" data-id="{{ $product->id }}" data-action="chat"><span
                            class="me-2"><i
                                class="far fa-comments"></i></span><span>{{ trans('web.Chat') }}</span></a>
                <a href="https://wa.me/{{ $product->whatsapp_number }}" target="_blank" class="btn btn-whatsapp addProductAction" data-id="{{ $product->id }}" data-action="whatsapp"><i
                            class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

@endif

