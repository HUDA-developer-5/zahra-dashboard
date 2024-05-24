<div class="modal main-modal adsReportModal fade" id="adsReportModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <div class="text-center">
                    <div class="modal-logo mb-2">
                        <img src="{{ asset('frontend/assets/images/icon.png') }}" alt="logo icon" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="modal-body pt-0">
                <h3 class="fw-bold text-center mb-3"> {{ trans('web.Are you sure you want to report this ads?') }}</h3>
                {{ html()->form('post', route('web.products.report', ['id' => $product_id]))->addClass('mb-3')->open() }}
                {{ html()->hidden('product_id', $product_id) }}
                <textarea name="comment" id="comment" rows="3" class="form-control"
                          placeholder="{{ trans('web.Why') }}" required></textarea>

                @if($errors->product_report->has("comment"))
                    <div class="error-note">
                        <span class="help-block text-danger">{{ $errors->product_report->first("comment") }}</span>
                    </div>
                @endif
                <div class="d-flex gap-2">
                    <button class="btn btn-gradiant py-2 w-50" type="submit"><span
                                class="fw-bold">{{ trans('web.Yas, iam Sure') }}</span></button>
                    <button class="btn btn-border py-2 w-50" data-bs-dismiss="modal" aria-label="Close"><span
                                class="fw-bold">{{ trans('web.Cancel') }}</span></button>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>