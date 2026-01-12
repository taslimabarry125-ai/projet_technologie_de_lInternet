<?php
// connexion.php - Page de connexion
require_once 'config.php';

// Initialiser les variables
$erreur = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $se_souvenir = isset($_POST['se_souvenir']);
    
    // Validation basique
    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs";
    } else {
        
        // Charger les utilisateurs
        $utilisateurs = chargerUtilisateurs();
        $utilisateurTrouve = null;
        
        // Chercher l'utilisateur
        foreach ($utilisateurs as $index => $user) {
            if ($user['email'] === $email) {
                $utilisateurTrouve = $user;
                $userIndex = $index;
                break;
            }
        }
        
        // Vérifier le mot de passe
        if ($utilisateurTrouve && password_verify($password, $utilisateurTrouve['password'])) {
            
            // Connexion réussie !
            $_SESSION['user_id'] = $utilisateurTrouve['id'];
            $_SESSION['user_prenom'] = $utilisateurTrouve['prenom'];
            $_SESSION['user_email'] = $utilisateurTrouve['email'];
            
            // Mettre à jour la dernière connexion
            $utilisateurs[$userIndex]['derniere_connexion'] = date('Y-m-d H:i:s');
            sauvegarderUtilisateurs($utilisateurs);
            
            // Si "Se souvenir de moi" est coché
            if ($se_souvenir) {
                // Créer un cookie qui dure 30 jours
                setcookie('user_email', $email, time() + COOKIE_DURATION, '/');
                setcookie('user_token', password_hash($utilisateurTrouve['id'], PASSWORD_DEFAULT), time() + COOKIE_DURATION, '/');
            }
            
            // Rediriger vers le dashboard
            header('Location: dashboard.php');
            exit;
            
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
    }
}

// Pré-remplir l'email si un cookie existe
$emailCookie = $_COOKIE['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - <?php echo SITE_NAME; ?></title>
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
                        <a class="nav-link active" href="connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- CONTENU -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <div class="card shadow">
                    <div class="card-body p-5">
                        
                        <h2 class="text-center mb-4">🔐 Connexion</h2>
                        
                        <!-- Message d'erreur -->
                        <?php if ($erreur): ?>
                            <div class="alert alert-danger">
                                <strong>❌ <?php echo $erreur; ?></strong>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulaire de connexion -->
                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($emailCookie); ?>"
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       required>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="se_souvenir" 
                                       name="se_souvenir"
                                       <?php echo $emailCookie ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="se_souvenir">
                                    Se souvenir de moi (cookie)
                                </label>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Se connecter
                                </button>
                            </div>
                            
                        </form>
                        
                        <hr class="my-4">
                        
                        <p class="text-center mb-0">
                            Pas encore inscrit ? 
                            <a href="inscription.php">Créer un compte</a>
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
    
</body>
</html>