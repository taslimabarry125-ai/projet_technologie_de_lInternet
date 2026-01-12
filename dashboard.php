<?php
// dashboard.php - Page personnelle de l'utilisateur (PROTÉGÉE)
require_once 'config.php';

// PROTECTION : Vérifier si l'utilisateur est connecté
if (!estConnecte()) {
    // Si pas connecté, rediriger vers la page de connexion
    header('Location: connexion.php');
    exit;
}

// Récupérer les infos de l'utilisateur
$utilisateur = utilisateurActuel();

// Si l'utilisateur n'existe plus (cas rare)
if (!$utilisateur) {
    session_destroy();
    header('Location: connexion.php');
    exit;
}

// Calculer des statistiques dynamiques
$joursDepuisInscription = floor((time() - strtotime($utilisateur['date_inscription'])) / 86400);
$derniereConnexion = $utilisateur['derniere_connexion'] ? date('d/m/Y à H:i', strtotime($utilisateur['derniere_connexion'])) : 'Première connexion';

// Heure de la journée pour message personnalisé
$heure = date('H');
if ($heure < 12) {
    $salutation = "Bonjour";
    $emoji = "☀️";
} elseif ($heure < 18) {
    $salutation = "Bon après-midi";
    $emoji = "🌤️";
} else {
    $salutation = "Bonsoir";
    $emoji = "🌙";
}

// Simuler des tâches (vous pourrez améliorer ça plus tard)
$taches = [
    ['titre' => 'Terminer le projet Web', 'statut' => 'en_cours', 'echeance' => '15/01/2025'],
    ['titre' => 'Réviser pour l\'examen PHP', 'statut' => 'en_cours', 'echeance' => '20/01/2025'],
    ['titre' => 'Lire documentation Bootstrap', 'statut' => 'complete', 'echeance' => '08/01/2025'],
    ['titre' => 'Créer le README.md', 'statut' => 'a_faire', 'echeance' => '12/01/2025'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dashboard - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .badge-en-cours {
            background-color: #ffc107;
        }
        .badge-complete {
            background-color: #28a745;
        }
        .badge-a-faire {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <strong>📚 <?php echo SITE_NAME; ?></strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Mon Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- CONTENU DYNAMIQUE -->
    <main class="container my-5">
        
        <!-- Message de bienvenue DYNAMIQUE -->
        <section class="hero text-center mb-5">
            <h1 class="display-4 mb-3">
                <?php echo $emoji; ?> <?php echo $salutation; ?>, <?php echo htmlspecialchars($utilisateur['prenom']); ?> !
            </h1>
            <p class="lead">Bienvenue sur votre espace personnel</p>
        </section>
        
        <!-- Statistiques personnelles -->
        <section class="mb-5">
            <h2 class="mb-4">📊 Vos statistiques</h2>
            <div class="row g-4">
                
                <div class="col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="display-4 text-primary mb-2">👤</div>
                        <h5><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?></h5>
                        <p class="text-muted mb-0">Votre nom complet</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="display-4 text-success mb-2">📅</div>
                        <h5><?php echo $joursDepuisInscription; ?> jour<?php echo $joursDepuisInscription > 1 ? 's' : ''; ?></h5>
                        <p class="text-muted mb-0">Depuis votre inscription</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="display-4 text-info mb-2">🕒</div>
                        <h5><?php echo $derniereConnexion; ?></h5>
                        <p class="text-muted mb-0">Dernière connexion</p>
                    </div>
                </div>
                
            </div>
        </section>
        
        <!-- Informations du compte -->
        <section class="mb-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">📧 Informations du compte</h5>
                            <ul class="list-unstyled">
                                <li><strong>Email :</strong> <?php echo htmlspecialchars($utilisateur['email']); ?></li>
                                <li><strong>Membre depuis :</strong> <?php echo date('d/m/Y', strtotime($utilisateur['date_inscription'])); ?></li>
                                <li><strong>Statut :</strong> <span class="badge bg-success">Actif</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">🔔 Rappels</h5>
                            <div class="alert alert-info mb-2">
                                <strong>📝 Projet Web</strong><br>
                                Échéance : 15/01/2025
                            </div>
                            <div class="alert alert-warning mb-0">
                                <strong>📚 Examen PHP</strong><br>
                                Échéance : 20/01/2025
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Liste des tâches dynamique -->
        <section class="mb-5">
            <h2 class="mb-4">✅ Mes tâches</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tâche</th>
                                    <th>Statut</th>
                                    <th>Échéance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($taches as $tache): ?>
                                    <tr>
                                        <td>
                                            <?php if ($tache['statut'] === 'complete'): ?>
                                                <del><?php echo htmlspecialchars($tache['titre']); ?></del>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($tache['titre']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $badges = [
                                                'en_cours' => ['class' => 'badge-en-cours', 'text' => 'En cours'],
                                                'complete' => ['class' => 'badge-complete', 'text' => 'Complétée'],
                                                'a_faire' => ['class' => 'badge-a-faire', 'text' => 'À faire']
                                            ];
                                            $badge = $badges[$tache['statut']];
                                            ?>
                                            <span class="badge <?php echo $badge['class']; ?>">
                                                <?php echo $badge['text']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $tache['echeance']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Actions rapides -->
        <section class="mb-5">
            <h2 class="mb-4">⚡ Actions rapides</h2>
            <div class="row g-3">
                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100" onclick="alert('Fonctionnalité à venir !')">
                        📝 Nouvelle tâche
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-success w-100" onclick="alert('Fonctionnalité à venir !')">
                        📊 Voir mes statistiques
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-info w-100" onclick="alert('Fonctionnalité à venir !')">
                        ⚙️ Paramètres
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="deconnexion.php" class="btn btn-outline-danger w-100">
                        🚪 Déconnexion
                    </a>
                </div>
            </div>
        </section>
        
    </main>
    
    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 <?php echo SITE_NAME; ?>. Tous droits réservés.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    
    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Dashboard chargé pour : <?php echo $utilisateur['prenom']; ?>');
            
            // Afficher une notification de bienvenue
            setTimeout(function() {
                console.log('👋 Bienvenue sur votre dashboard personnalisé !');
            }, 500);
        });
    </script>
    
</body>
</html>