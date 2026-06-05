<?php
/**
 * Garde d'accès : à inclure en haut de chaque page d'administration.
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
 */
require_once __DIR__ . '/config.php';

if (!tmk_is_logged_in()) {
    header('Location: login.php');
    exit;
}
