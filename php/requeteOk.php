<?php
// Logique PHP inchangée - Prête pour intégration de la vérification de session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Intégrer la logique de vérification ici
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Utilisateur - Repair Café</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="images/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Authentification</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="../index.html" class="nav-link">Accueil</a></li>
                <li><a href="dashboard.php" class="nav-link active">Espace Service</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card">
            <h1>Connexion Utilisateur</h1>
            <p style="margin-bottom: 1.5rem; color:#666;">Saisissez vos identifiants pour accéder à votre espace.</p>

            <form action="user_connect.php" method="POST">
                <div class="form-group">
                    <label for="nom">Nom de famille :</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Se connecter</button>
                
                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                    Pas encore de compte ? <a href="create_user.php" style="color: var(--color-primary); font-weight: bold;">Créer un profil</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>
