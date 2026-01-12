<?php
// deconnexion.php - Script de déconnexion
require_once 'config.php';

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Supprimer les cookies "Se souvenir de moi" (optionnel)
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_token'])) {
    setcookie('user_token', '', time() - 3600, '/');
}

// Rediriger vers la page d'accueil avec message
header('Location: index.php');
exit;
?>