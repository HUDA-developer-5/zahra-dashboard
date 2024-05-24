<?php
return [
    'test_mode' => env('STRIPE_TEST_MODE', false),
    'currency' => env('CASHIER_CURRENCY', 'SAR'),
    'stripe_key' => env('STRIPE_KEY', null),
    'secret_key' => env('STRIPE_SECRET', null),
    'return_auth' => '/api/payment/return-stripe',
    'return_cancel' => '/api/payment/return-stripe',
    'return_declined' => '/api/payment/return-stripe'
];
