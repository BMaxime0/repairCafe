<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Service - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo Repair Café" class="logo-img">
                <h2>Espace Service</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="../index.html" class="nav-link">Accueil</a></li>
                <li><a href="/php/dashboard.php" class="nav-link active">Espace Service</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <h1 style="text-align: center;">Que souhaitez-vous faire ?</h1>
        <p style="text-align: center; color: #666;">Sélectionnez une option ci-dessous pour interagir avec la plateforme du Repair Café.</p>

        <div class="dashboard-grid">
            <div class="info-card" style="text-align: center;">
                <h3>Espace Utilisateur</h3>
                <p style="margin-bottom: 1.5rem;">Connectez-vous à votre compte étudiant ou personnel pour suivre vos demandes.</p>
                <a href="user_connect.php" class="btn" style="width: 100%;">Se connecter</a>
            </div>

            <div class="info-card" style="text-align: center;">
                <h3>Espace Réparateur</h3>
                <p style="margin-bottom: 1.5rem;">Accès réservé aux techniciens et bénévoles pour la gestion des fiches d'atelier.</p>
                <a href="reparateur_connect.php" class="btn btn-secondary" style="width: 100%;">Espace Technique</a>
            </div>

            <div class="info-card" style="text-align: center;">
                <h3>Nouvelle Requête</h3>
                <p style="margin-bottom: 1.5rem;">Formuler une demande d'assistance ou de location de matériel.</p>
                <a href="requete.php" class="btn" style="width: 100%;">Faire une requête</a>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>
