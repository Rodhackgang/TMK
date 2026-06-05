<?php
// Inclure l'autoload de Composer pour Stripe
require __DIR__ . "/vendor/autoload.php";

// Clé secrète Stripe (dans config-stripe.php, non versionné)
$stripe_secret_key = is_file(__DIR__ . '/config-stripe.php')
    ? require __DIR__ . '/config-stripe.php'
    : (getenv('STRIPE_SECRET_KEY') ?: '');

\Stripe\Stripe::setApiKey($stripe_secret_key);

// Créer la session de paiement Stripe
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/success.php",  // URL de succès
    "cancel_url" => "http://localhost:8000/cancel.php",    // URL d'annulation
    "locale" => "es",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",  // La devise
                "unit_amount" => 1000, // Montant en centimes (10 USD)
                "product_data" => [
                    "name" => "TMK_FOUNDATION"  // Nom du produit
                ]
            ]
        ]
    ]
]);

// Code HTML avec un bouton pour payer
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Stripe</title>
</head>
<body>
    <h1>Payer avec Stripe</h1>
    <!-- Bouton de paiement -->
    <form action="<?= $checkout_session->url ?>" method="get">
        <button type="submit">Payer</button>
    </form>
</body>
</html>
