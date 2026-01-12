<?php
// config.php - Configuration du site

// Démarrer la session (permet de garder l'utilisateur connecté)
session_start();

// Nom du site
define('SITE_NAME', 'StudyHub');

// Chemins des fichiers
define('USERS_FILE', __DIR__ . '/data/users.json');

// Durée du cookie "Se souvenir de moi" (30 jours)
define('COOKIE_DURATION', 30 * 24 * 60 * 60);

// Fonction pour charger les utilisateurs depuis le fichier JSON
function chargerUtilisateurs() {
    if (!file_exists(USERS_FILE)) {
        // Si le fichier n'existe pas, créer un tableau vide
        return [];
    }
    
    $contenu = file_get_contents(USERS_FILE);
    return json_decode($contenu, true) ?? [];
}

// Fonction pour sauvegarder les utilisateurs dans le fichier JSON
function sauvegarderUtilisateurs($utilisateurs) {
    // Créer le dossier data s'il n'existe pas
    if (!file_exists(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data', 0777, true);
    }
    
    $json = json_encode($utilisateurs, JSON_PRETTY_PRINT);
    file_put_contents(USERS_FILE, $json);
}

// Fonction pour vérifier si l'utilisateur est connecté
function estConnecte() {
    return isset($_SESSION['user_id']);
}

// Fonction pour obtenir l'utilisateur actuel
function utilisateurActuel() {
    if (!estConnecte()) {
        return null;
    }
    
    $utilisateurs = chargerUtilisateurs();
    foreach ($utilisateurs as $user) {
        if ($user['id'] == $_SESSION['user_id']) {
            return $user;
        }
    }
    
    return null;
}
?>