<div class="modal main-modal offerModal fade" id="offerModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0 p-0 pb-2">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="d-flex gap-2 mb-3">
                    <img src="{{ $product_image }}" alt="image" class="ads-img">
                    <p class="fw-600 text-dark mb-0">{{ $product_name }}</p>
                </div>
                {{ html()->form('post', route('web.products.addOffer', ['id' => $product_id]))->open() }}
                <div class="form-input mb-3">
                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                    <input type="number" min="1" id="ads-offer" name="offer" class="form-control" placeholder="{{ trans('web.Offer') }}">
                    <label class="form-label" for="ads-offer">{{ trans('web.Offer') }}</label>
                </div>
                <div>
                    <button class="btn btn-gradiant fw-bold w-100" type="submit">{{ trans('web.Send Offer') }}</button>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>