<?php
require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = is_file(__DIR__ . '/config-stripe.php')
    ? require __DIR__ . '/config-stripe.php'
    : (getenv('STRIPE_SECRET_KEY') ?: ''); // clé dans config-stripe.php (non versionné)
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Récupérer le montant depuis la requête POST
$input = json_decode(file_get_contents('php://input'), true);
$amount = intval($input['amount']);

// Créer la session de paiement
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/index.php?payment=success",
    "cancel_url" => "http://localhost:8000/index.php?payment=failed",
    "locale" => "fr", // Changé à 'fr' pour français
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => $amount,
                "product_data" => [
                    "name" => "Don à TMK_FOUNDATION"
                ]
            ]
        ]
    ]
]);

header('Content-Type: application/json');
echo json_encode(['url' => $checkout_session->url]);
?>