<div class="modal addNewCardModal fade" id="addNewCardModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <h3 class="text-capitalize text-center fw-bold mb-0">{{ trans('web.Add new Card') }}</h3>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="form-group">
                        <label for="card-holder-name">{{ trans('web.Name') }}</label>
                        <input id="card-holder-name" class="form-control only-text" type="text"
                               placeholder="{{ trans('web.Name') }}">
                    </div>

                    <div class="form-group">
                        <label for="card-element">{{ trans('web.Card Details') }}</label>
                        <div id="card-element" class="form-control"></div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check validate-input order-2 order-sm-1">
                            <input class="form-check-input checkInput" name="remember" type="checkbox"
                                   id="flexCheckChecked-1" required>
                            <label class="form-check-label fw-bold fs-7" for="flexCheckChecked-1">
                                {{ trans('web.By adding a new card, I agree with the') }} <a data-bs-toggle="modal" href="#termsModal" role="button" class="text-decoration-underline text-primary">{{ trans('web.Terms of use & Privacy policy') }}</a>
                            </label>
                            <div class="error-note"></div>
                        </div>
                    </div>

                    <div>
                        <button id="card-button" class="btn btn-gradiant fw-bold w-100"
                                data-secret="{{ $intent }}">{{ trans('web.Save your data') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($termsAndConditions))
<div class="modal termsModal fade" id="termsModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header justify-content-center border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('frontend/assets/images/icons/close.svg') }}" alt="close image">
                </button>
                <h3 class="text-capitalize text-center fw-bold mb-0">{{ $termsAndConditions->{'title_' . app()->getLocale()} }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ $termsAndConditions->{'content_' . app()->getLocale()} }}</p>
                <div class="text-center">
                    <a data-bs-toggle="modal" href="#addNewCardModal" role="button" class="text-primary">
                        <i class="fas fa-chevron-left"></i>
                        <span class="ms-3 fw-600">{{ trans('web.Back to add new card') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe("{{config('stripe.stripe_key')}}");
    var elements = stripe.elements();
    var cardElement = elements.create('card', {
        hidePostalCode: true
    });
    cardElement.mount('#card-element');

    var form = document.getElementById('payment-form');
    var cardButton = document.getElementById('card-button');

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        cardButton.disabled = true;

        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: document.getElementById('card-holder-name').value
            }
        }).then(function (result) {
            if (result.error) {
                console.error(result.error.message);
                cardButton.disabled = false;
            } else {
                handleCardPaymentMethod(result.paymentMethod.id);
            }
        });
    });


    function handleCardPaymentMethod(paymentMethod) {
        console.log(paymentMethod);
        var formData = new FormData();
        formData.append('payment_method', paymentMethod);

        fetch("{{route('web.pay.process')}}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                $("#addNewCardModal").modal('hide');
                // refresh page
                location.reload();
            })
            .catch(error => {
                alert(error);
            });
    }
</script>