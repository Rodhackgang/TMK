<?php
require './utils/header.php';
?>
<style>
    #hero.hero.section {
        margin-top: 80px;
        padding-top: 40px;
    }
</style>

<section id="hero" class="hero section">
    <div class="hero-container">
        <div class="form-container">
            <!-- Section Connexion -->
            <div class="form-card">
                <h3 class="text-center text-primary">Connexion</h3>
                <form action="login.php" method="POST" autocomplete="off">
                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre email avec quelqu'un d'autre.</small>
                    </div>

                    <!-- Mot de Passe Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    </div>
<!--
                 
                    <center>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                        </div>
                    </center>
                </form>
-->
                <!-- Forgot Password Link -->
                <div class="mt-3 text-center">
                    <a href="#" id="forgotPasswordLink" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Mot de passe oublié ?</a>
                </div>

                <!-- Button to Navigate to Register Page -->
                <center>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-secondary btn-lg" onclick="window.location.href='./Register.php'">S'inscrire</button>
                    </div>
                </center>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Reset Password -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="forgotPasswordModalLabel">Réinitialisation du mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="reset-password.php" method="POST" id="resetPasswordForm">
                    <div class="mb-3">
                        <label for="resetEmail" class="form-label">Entrez votre email</label>
                        <input type="email" class="form-control" id="resetEmail" name="resetEmail" placeholder="Entrez votre email pour réinitialiser le mot de passe" required aria-describedby="resetEmailHelp">
                        <small id="resetEmailHelp" class="form-text text-muted">Vous recevrez un lien pour réinitialiser votre mot de passe.</small>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require './utils/footer.php';
?>

<script>
    // JavaScript to open the modal when the forgot password link is clicked
    document.getElementById('forgotPasswordLink').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
        myModal.show();
    });
</script>

<style>
    /* Centrer le contenu de la page */
    #hero {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f7fa;
        /* Ajout d'une couleur de fond douce */
    }

    /* Conteneur général */
    .hero-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 600px;
    }

    /* Style de la carte */
    .form-card {
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    h3 {
        font-size: 24px;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 20px;
    }

    /* Amélioration des champs de formulaire */
    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 15px;
        font-size: 16px;
    }

    /* Style des boutons */
    .btn {
        border-radius: 8px;
        font-size: 16px;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        margin-bottom: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-lg {
        padding: 15px;
    }

    .d-grid {
        margin-top: 15px;
    }

    /* Styles pour les liens */
    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Modal */
    .modal-content {
        border-radius: 15px;
        padding: 20px;
    }

    .modal-header {
        border-bottom: 2px solid #ddd;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-title {
        font-size: 18px;
        color: #007bff;
    }
</style>