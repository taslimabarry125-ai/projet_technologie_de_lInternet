# 📚 StudyHub - Plateforme Étudiante

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.0+-purple)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-blue)

##  Description du projet

**StudyHub** est une plateforme web moderne conçue pour aider les étudiants à organiser leurs études, gérer leurs tâches et suivre leur progression académique.

Ce projet a été développé dans le cadre du cours **Technologies de l'Internet** et démontre la maîtrise de :
- Conception web responsive
- Authentification utilisateur sécurisée
- Gestion de sessions et cookies
- Pages dynamiques personnalisées
- Intégration multimédia

---

## ✨ Fonctionnalités

### 🔐 Authentification
- **Inscription** : Création de compte avec validation des champs
- **Connexion** : Authentification sécurisée avec hash des mots de passe (bcrypt)
- **Sessions PHP** : Gestion des utilisateurs connectés
- **Cookies** : Option "Se souvenir de moi" (30 jours)
- **Déconnexion** : Destruction propre de la session et des cookies

### 🎯 Dashboard personnalisé
- Message de bienvenue dynamique selon l'heure (matin/après-midi/soir)
- Affichage du nom complet de l'utilisateur
- Statistiques personnelles :
  - Nombre de jours depuis l'inscription
  - Date de dernière connexion
  - Email du compte
- Liste de tâches avec statuts (En cours, Complétée, À faire)
- Rappels d'échéances importantes

### 🎨 Interface utilisateur
- Design moderne et professionnel avec **Bootstrap 5**
- **Responsive** : S'adapte à tous les écrans (mobile, tablette, desktop)
- Header avec navigation dynamique
- Footer avec informations de contact
- Animations CSS fluides
- Messages d'erreur et de succès clairs

### 🎵 Multimédia
- Intégration d'un lecteur **audio** (musique d'ambiance)
- Intégration d'un lecteur **vidéo** (présentation de la plateforme)
- Lecteurs HTML5 compatibles tous navigateurs

### 🔒 Sécurité
- **Hash des mots de passe** avec `password_hash()` (bcrypt)
- **Protection XSS** avec `htmlspecialchars()`
- **Protection des pages** : Redirection automatique si non connecté
- **Validation des formulaires** côté serveur et client
- Stockage sécurisé en fichier JSON

---

## 🛠️ Technologies utilisées

| Technologie | Utilisation |
|-------------|-------------|
| **HTML5** | Structure des pages |
| **CSS3** | Styles personnalisés et animations |
| **Bootstrap 5.3** | Framework CSS responsive |
| **JavaScript** | Validation formulaires et interactions |
| **PHP 8.0+** | Logique serveur et authentification |
| **JSON** | Stockage des données utilisateurs |
| **Git & GitHub** | Versioning et hébergement du code |

---

## 📁 Structure du projet
plateforme-etudiante/
│
├── index.php              # Page d'accueil
├── inscription.php        # Page d'inscription
├── connexion.php          # Page de connexion
├── dashboard.php          # Dashboard utilisateur (protégé)
├── deconnexion.php        # Script de déconnexion
├── config.php             # Configuration et fonctions globales
│
├── css/
│   └── style.css         # Styles personnalisés
│
├── js/
│   └── script.js         # JavaScript personnalisé
│
├── media/
│   ├── audio/
│   │   └── musique.mp3   # Fichier audio
│   └── video/
│       └── presentation.mp4  # Fichier vidéo
│
├── data/
│   └── users.json        # Base de données utilisateurs (JSON)
│
└── README.md             # Documentation du projet
---

##  Installation et configuration

### Prérequis

- **WAMP** / **XAMPP** / **MAMP** (serveur local avec PHP)
- **Navigateur web** moderne (Chrome, Firefox, Edge)
- **Git** (optionnel, pour cloner le projet)

### Étapes d'installation

1. **Cloner le dépôt** (ou télécharger le ZIP)
```bash
   git clone https://github.com/VOTRE_USERNAME/plateforme-etudiante.git
```

2. **Placer le projet dans le dossier web**
   - WAMP : `C:\wamp64\www\plateforme-etudiante\`
   - XAMPP : `C:\xampp\htdocs\plateforme-etudiante\`
   - MAMP : `/Applications/MAMP/htdocs/plateforme-etudiante/`

3. **Créer le fichier de données**
   - Vérifier que le dossier `data/` existe
   - Vérifier que `users.json` contient : `[]`

4. **Démarrer le serveur**
   - Démarrer WAMP/XAMPP/MAMP
   - S'assurer que l'icône est **verte**

5. **Accéder au site**
    - http://localhost/plateforme-etudiante/

## 👤 Utilisation

### 1. Créer un compte

1. Cliquer sur **"Inscription"** dans le menu
2. Remplir le formulaire :
   - Prénom
   - Nom
   - Email (format valide requis)
   - Mot de passe (minimum 6 caractères)
   - Confirmation du mot de passe
3. Cliquer sur **"S'inscrire"**
4. Redirection automatique vers la page de connexion

### 2. Se connecter

1. Entrer votre **email** et **mot de passe**
2. (Optionnel) Cocher **"Se souvenir de moi"** pour rester connecté
3. Cliquer sur **"Se connecter"**
4. Redirection vers votre dashboard personnel

### 3. Accéder au dashboard

Une fois connecté :
- Voir vos informations personnelles
- Consulter vos statistiques
- Gérer vos tâches et rappels
- Accéder aux fonctionnalités premium

### 4. Se déconnecter

- Cliquer sur **"Déconnexion"** dans le menu
- La session est détruite et vous êtes redirigé vers l'accueil

## 🎯 Défis rencontrés et solutions

### Défi 1 : Gestion des sessions PHP
**Problème :** Sessions perdues entre les pages

**Solution :** Ajouter `session_start()` dans `config.php` et inclure ce fichier en premier dans chaque page.

### Défi 2 : Hash des mots de passe
**Problème :** Comprendre comment sécuriser les mots de passe

**Solution :** Utilisation de `password_hash()` pour créer un hash bcrypt et `password_verify()` pour vérifier lors de la connexion.

### Défi 3 : Responsive design
**Problème :** Menu de navigation encombré sur mobile

**Solution :** Utilisation du composant Navbar de Bootstrap avec collapse automatique en mode burger sur petits écrans.

### Défi 4 : Protection des pages
**Problème :** Accès direct au dashboard sans connexion

**Solution :** Vérification de session en début de page avec redirection automatique si non connecté.

### Défi 5 : Stockage des données
**Problème :** Pas de base de données MySQL disponible rapidement

**Solution :** Utilisation de fichiers JSON pour stocker les utilisateurs, plus simple et rapide pour un prototype.

---

##  Améliorations futures

Voici des fonctionnalités qui pourraient être ajoutées dans une future version :

-  **Migration vers MySQL** : Base de données relationnelle pour plus de performance
-  **Graphiques de progression** : Visualisation des statistiques 
-  **Système de notifications** : Emails automatiques pour les rappels
-  **Profils utilisateurs** : Photos de profil et informations personnalisées
-  **Synchronisation cloud** : Backup automatique des données
-  **Mode sombre** : Thème alternatif pour réduire la fatigue oculaire
-  **Recherche avancée** : Filtrage et tri des tâches
-  **Application mobile** : Version React Native pour iOS/Android
-  **Calendrier intégré** : Vue agenda des échéances

---

##  Ressources utilisées

- [Documentation PHP Officielle](https://www.php.net/docs.php)
- [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [W3Schools PHP Tutorial](https://www.w3schools.com/php/)

