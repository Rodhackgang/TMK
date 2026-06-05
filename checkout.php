<?php

require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = is_file(__DIR__ . '/config-stripe.php')
    ? require __DIR__ . '/config-stripe.php'
    : (getenv('STRIPE_SECRET_KEY') ?: '');

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/success.php",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => 10,
                "product_data" => [
                    "name" => "TMK_FOUNDATION"
                ]
            ]
        ]
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session-> url );