<?php
require_once __DIR__ . '/config.php';

// Déjà connecté ? -> tableau de bord
if (tmk_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        $error = "Session expirée, veuillez réessayer.";
    } else {
        $user = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';
        if (hash_equals(TMK_ADMIN_USER, $user) && hash_equals(TMK_ADMIN_PASS, $pass)) {
            session_regenerate_id(true);
            $_SESSION['tmk_admin'] = $user;
            header('Location: index.php');
            exit;
        }
        $error = "Identifiant ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion · TMK Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../images/logo.png">
    <style>
        body { min-height:100vh; display:flex; align-items:center; justify-content:center;
               background: linear-gradient(135deg, #0f2747, #14375f); font-family:'Segoe UI', sans-serif; }
        .login-card { width:100%; max-width:400px; background:#fff; border-radius:18px; padding:38px 32px;
                      box-shadow:0 20px 50px rgba(0,0,0,.3); }
        .login-card img { width:64px; height:64px; object-fit:contain; }
        .login-card h1 { font-size:20px; font-weight:700; color:#13294a; }
        .btn-tmk { background:#5B8FD9; border-color:#5B8FD9; color:#fff; font-weight:600; }
        .btn-tmk:hover { background:#4a7bc7; color:#fff; }
    </style>
</head>
<body>
    <form class="login-card text-center" method="post" autocomplete="off">
        <img src="../images/logo.png" alt="TMK">
        <h1 class="mt-3 mb-1">Administration TMK</h1>
        <p class="text-muted small mb-4">The Miracle Kingdom Foundation</p>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?= tmk_csrf_field() ?>
        <div class="mb-3 text-start">
            <label class="form-label small fw-semibold">Identifiant</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
        </div>
        <div class="mb-4 text-start">
            <label class="form-label small fw-semibold">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-tmk w-100 py-2">
            <i class="fa-solid fa-right-to-bracket"></i> Se connecter
        </button>
    </form>
</body>
</html>
