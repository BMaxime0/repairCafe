<?php
session_start();
require_once 'db_connect.php';

$message_erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Récupération et nettoyage des données du formulaire
    $mail = trim($_POST['mail'] ?? '');
    $password_saisi = $_POST['password'] ?? '';

    if (!empty($mail) && !empty($password_saisi)) {
        try {
            //On cherche le réparateur par son adresse mail
            $requete = $pdo->prepare("SELECT * FROM reparateur WHERE mail = :mail");
            $requete->execute([
                ":mail" => $mail
            ]);
            
            $reparateur = $requete->fetch();

            //On vérifie si le réparateur existe ET si le mot de passe correspond au hash
            if ($reparateur && password_verify($password_saisi, $reparateur['password'])) {
                
                $_SESSION['reparateur_id'] = $reparateur['id']; 
                $_SESSION['nom_repa']      = $reparateur['nom'];
                $_SESSION['prenom_repa']   = $reparateur['prenom'];
                
                // Redirection vers le dashboard réparateur
                header("Location: dashboard_reparateur.php"); 
                exit();

            } else {
                $message_erreur = "Adresse mail ou mot de passe incorrect.";
            }

        } catch (PDOException $e) {
            $message_erreur = "Erreur système : " . $e->getMessage();
        }
    } else {
        $message_erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Réparateur - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Espace Réparateur</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="../html/Acceuil.html" class="nav-link">Accueil</a></li>
                <li><a href="user_connect.php" class="nav-link">Espace Client</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card">
            <h1>Connexion Staff</h1>
            <p style="margin-bottom: 1.5rem; color:#666;">Réservé aux réparateurs du Repair Café.</p>

            <?php if (!empty($message_erreur)): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
                    <?php echo htmlspecialchars($message_erreur); ?>
                </div>
            <?php endif; ?>

            <form action="reparateur_connect.php" method="POST">
                <div class="form-group">
                    <label for="mail">Adresse email pro :</label>
                    <input type="email" id="mail" name="mail" class="form-control" required placeholder="nom@repaircafe.fr">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; background-color: #007bff;">
                    Se connecter à l'atelier
                </button>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>