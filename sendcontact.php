<?php
            $messageSent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Remplacez par votre clé API Telegram et votre chat ID
    $apiKey = '6447786390:AAGSMoB0DxpkUgvN1WV8u1tOnr-6bFAHJMA';  
    $chatId = '6192345184';

    // Créer le texte du message
    $messageText = "Nom: $name\nEmail: $email\nObjet: $subject\nMessage: $message";

    // URL de l'API Telegram pour envoyer un message
    $url = "https://api.telegram.org/bot$apiKey/sendMessage?chat_id=$chatId&text=" . urlencode($messageText);

    // Initialiser cURL pour envoyer la requête à Telegram
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    // Vérifier si l'envoi a réussi
    if ($response) {
        $messageSent = true;
        header("Location: index.php#contact"); 
        echo "<div class='alert alert-success'>Message envoyé avec succès!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'envoi du message.</div>";
    }
}
?>
