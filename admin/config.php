<?php
/**
 * ════════════════════════════════════════════════════════════════
 *  TMK - Configuration de l'administration
 * ════════════════════════════════════════════════════════════════
 *  ⚠️  IMPORTANT : changez l'identifiant et le mot de passe ci-dessous
 *      avant la mise en ligne du site.
 * ════════════════════════════════════════════════════════════════
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../utils/content-store.php';

// ─── Identifiants administrateur ───────────────────────────────
// Identifiant de connexion
if (!defined('TMK_ADMIN_USER')) {
    define('TMK_ADMIN_USER', 'admin');
}
// Mot de passe (à modifier !). Par défaut : tmk2025
if (!defined('TMK_ADMIN_PASS')) {
    define('TMK_ADMIN_PASS', 'tmk2025');
}

/** Vérifie si l'administrateur est connecté */
function tmk_is_logged_in()
{
    return !empty($_SESSION['tmk_admin']);
}

/** Génère / récupère le jeton CSRF de la session */
function tmk_csrf_token()
{
    if (empty($_SESSION['tmk_csrf'])) {
        $_SESSION['tmk_csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['tmk_csrf'];
}

/** Champ caché à insérer dans chaque formulaire */
function tmk_csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(tmk_csrf_token()) . '">';
}

/** Valide le jeton CSRF d'une requête POST */
function tmk_csrf_check()
{
    $token = $_POST['csrf'] ?? '';
    return is_string($token) && !empty($_SESSION['tmk_csrf']) && hash_equals($_SESSION['tmk_csrf'], $token);
}

/** Mémorise un message flash affiché à la prochaine page */
function tmk_flash($message, $type = 'success')
{
    $_SESSION['tmk_flash'] = ['message' => $message, 'type' => $type];
}

/** Récupère et efface le message flash courant */
function tmk_get_flash()
{
    if (!empty($_SESSION['tmk_flash'])) {
        $flash = $_SESSION['tmk_flash'];
        unset($_SESSION['tmk_flash']);
        return $flash;
    }
    return null;
}
