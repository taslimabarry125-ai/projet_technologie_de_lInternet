<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
?>
<?php
// index.php - Page d'accueil
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Accueil</title>
    
    <!-- Bootstrap CSS pour le responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Nos styles personnalisés -->
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    
    <!-- HEADER avec navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <strong>📚 <?php echo SITE_NAME; ?></strong>
            </a>
            
            <!-- Bouton menu mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu de navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    
                    <?php if (estConnecte()): ?>
                        <!-- Si connecté -->
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Mon Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <!-- Si non connecté -->
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">Inscription</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- CONTENU PRINCIPAL -->
    <main class="container my-5">
        
        <!-- Section Hero -->
        <section class="hero text-center mb-5">
            <h1 class="display-4 mb-3">Bienvenue sur <?php echo SITE_NAME; ?> 🎓</h1>
            <p class="lead">Votre plateforme étudiante pour gérer vos études efficacement</p>
            
            <?php if (!estConnecte()): ?>
                <div class="mt-4">
                    <a href="inscription.php" class="btn btn-primary btn-lg me-2">S'inscrire</a>
                    <a href="connexion.php" class="btn btn-outline-primary btn-lg">Se connecter</a>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Section Vidéo -->
        <section class="mb-5">
            <h2 class="mb-4">🎥 Présentation vidéo</h2>
            <div class="ratio ratio-16x9">
                <!-- Vous pouvez mettre votre propre vidéo ou utiliser YouTube -->
                <video controls>
                    <source src="media/video/presentation.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
                
                <!-- Alternative avec YouTube (décommentez si besoin) -->
                <!-- <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe> -->
            </div>
        </section>
        
        <!-- Section Audio -->
        <section class="mb-5">
            <h2 class="mb-4">🎵 Musique d'ambiance</h2>
            <audio controls class="w-100">
                <source src="media/audio/musique.mp3" type="audio/mpeg">
                Votre navigateur ne supporte pas l'audio.
            </audio>
            
            <!-- Alternative avec SoundCloud (décommentez si besoin) -->
            <!-- <iframe width="100%" height="166" scrolling="no" frameborder="no" 
                    src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/VOTRE_TRACK">
            </iframe> -->
        </section>
        
        <!-- Section Fonctionnalités -->
        <section class="mb-5">
            <h2 class="mb-4 text-center">✨ Nos fonctionnalités</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="display-4 mb-3">📝</div>
                            <h5 class="card-title">Gestion des tâches</h5>
                            <p class="card-text">Organisez vos devoirs et projets efficacement</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="display-4 mb-3">📊</div>
                            <h5 class="card-title">Suivi de progression</h5>
                            <p class="card-text">Visualisez vos progrès en temps réel</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="display-4 mb-3">🔔</div>
                            <h5 class="card-title">Rappels</h5>
                            <p class="card-text">Ne manquez plus aucune échéance</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </main>
    
    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>📚 <?php echo SITE_NAME; ?></h5>
                    <p>Plateforme étudiante créée avec ❤️</p>
                </div>
                
                <div class="col-md-3">
                    <h6>Liens utiles</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white-50">Accueil</a></li>
                        <li><a href="connexion.php" class="text-white-50">Connexion</a></li>
                        <li><a href="inscription.php" class="text-white-50">Inscription</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6>Contact</h6>
                    <p class="text-white-50">
                        📧 contact@studyhub.fr<br>
                        📱 +33 1 23 45 67 89
                    </p>
                </div>
            </div>
            
            <hr class="bg-white">
            
            <div class="text-center">
                <p class="mb-0">&copy; 2025 <?php echo SITE_NAME; ?>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Notre JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>
