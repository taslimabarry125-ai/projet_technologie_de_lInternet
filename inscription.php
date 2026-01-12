<?php
// inscription.php - Page d'inscription
require_once 'config.php';

// Initialiser les variables
$erreurs = [];
$succes = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupérer et nettoyer les données
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // VALIDATION DES CHAMPS
    
    // Vérifier que tous les champs sont remplis
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est obligatoire";
    }
    
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide";
    }
    
    if (empty($password)) {
        $erreurs[] = "Le mot de passe est obligatoire";
    } elseif (strlen($password) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères";
    }
    
    if ($password !== $password_confirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas";
    }
    
    // Vérifier si l'email existe déjà
    if (empty($erreurs)) {
        $utilisateurs = chargerUtilisateurs();
        
        foreach ($utilisateurs as $user) {
            if ($user['email'] === $email) {
                $erreurs[] = "Cet email est déjà utilisé";
                break;
            }
        }
    }
    
    // Si pas d'erreurs, créer le compte
    if (empty($erreurs)) {
        
        // Créer le nouvel utilisateur
        $nouvelUtilisateur = [
            'id' => uniqid(), // Générer un ID unique
            'prenom' => htmlspecialchars($prenom),
            'nom' => htmlspecialchars($nom),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT), // HASH sécurisé
            'date_inscription' => date('Y-m-d H:i:s'),
            'derniere_connexion' => null
        ];
        
        // Ajouter à la liste
        $utilisateurs[] = $nouvelUtilisateur;
        
        // Sauvegarder dans le fichier JSON
        sauvegarderUtilisateurs($utilisateurs);
        
        // Message de succès
        $succes = "Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.";
        
        // Redirection après 2 secondes
        header("refresh:2;url=connexion.php");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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
                        <a class="nav-link" href="connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="inscription.php">Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- CONTENU -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div class="card shadow">
                    <div class="card-body p-5">
                        
                        <h2 class="text-center mb-4">📝 Inscription</h2>
                        
                        <!-- Messages d'erreur -->
                        <?php if (!empty($erreurs)): ?>
                            <div class="alert alert-danger">
                                <strong>❌ Erreur(s) :</strong>
                                <ul class="mb-0">
                                    <?php foreach ($erreurs as $erreur): ?>
                                        <li><?php echo $erreur; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Message de succès -->
                        <?php if ($succes): ?>
                            <div class="alert alert-success">
                                <strong>✅ <?php echo $succes; ?></strong><br>
                                Redirection en cours...
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulaire d'inscription -->
                        <form method="POST" action="" id="formInscription">
                            
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="<?php echo htmlspecialchars($prenom ?? ''); ?>"
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nom" 
                                       name="nom" 
                                       value="<?php echo htmlspecialchars($nom ?? ''); ?>"
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                       required>
                                <small class="text-muted">Ex: exemple@email.com</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       minlength="6"
                                       required>
                                <small class="text-muted">Minimum 6 caractères</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirmer le mot de passe *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       minlength="6"
                                       required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    S'inscrire
                                </button>
                            </div>
                            
                        </form>
                        
                        <hr class="my-4">
                        
                        <p class="text-center mb-0">
                            Déjà inscrit ? 
                            <a href="connexion.php">Se connecter</a>
                        </p>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </main>
    
    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 <?php echo SITE_NAME; ?>. Tous droits réservés.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    
    <!-- Validation JavaScript -->
    <script>
        // Validation en temps réel du formulaire
        document.getElementById('formInscription').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;
            
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('❌ Les mots de passe ne correspondent pas !');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('❌ Le mot de passe doit contenir au moins 6 caractères !');
                return false;
            }
        });
        
        // Afficher la force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let force = 'Faible';
            let couleur = 'danger';
            
            if (password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
                force = 'Fort';
                couleur = 'success';
            } else if (password.length >= 6) {
                force = 'Moyen';
                couleur = 'warning';
            }
            
            // Afficher un indicateur (optionnel)
            console.log('Force du mot de passe:', force);
        });
    </script>
    
</body>
</html>