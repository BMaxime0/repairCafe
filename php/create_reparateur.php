<?php
session_start();

// 1. Verrou de sécurité : Seul un staff connecté peut ajouter un autre staff
if (!isset($_SESSION['reparateur_id'])) {
    header("Location: login_reparateur.php");
    exit();
}

require_once 'db_connect.php';

$message_succes = "";
$message_erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($password) && !empty($confirm_password)) {
        
        // Vérification que les mots de passe correspondent
        if ($password === $confirm_password) {
            
            try {
                // Vérification si l'email existe déjà
                $checkMail = $pdo->prepare("SELECT id FROM reparateur WHERE mail = :mail");
                $checkMail->execute([":mail" => $mail]);
                
                if ($checkMail->fetch()) {
                    $message_erreur = "Un réparateur possède déjà cette adresse email.";
                } else {
                    // ✅ Le hash du mot de passe
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    // Insertion dans la base
                    $requete = $pdo->prepare("INSERT INTO reparateur (nom, prenom, mail, password) VALUES (:nom, :prenom, :mail, :password)");
                    $requete->execute([
                        ":nom"      => $nom,
                        ":prenom"   => $prenom,
                        ":mail"     => $mail,
                        ":password" => $password_hash
                    ]);

                    $message_succes = "Le réparateur $prenom $nom a été ajouté avec succès ! Il peut désormais se connecter.";
                }
            } catch (PDOException $e) {
                $message_erreur = "Erreur lors de la création : " . $e->getMessage();
            }

        } else {
            $message_erreur = "Les mots de passe ne correspondent pas.";
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
    <title>Ajouter un Réparateur - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Administration Staff</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="dashboard_reparateur.php" class="nav-link">Retour au Dashboard</a></li>
                <li><a href="logout_reparateur.php" class="nav-link" style="color: red;">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card">
            <h1>Ajouter un Réparateur</h1>
            <p style="margin-bottom: 1.5rem; color:#666;">Créez un accès back-office pour un nouveau collègue.</p>

            <?php if (!empty($message_succes)): ?>
                <div style="background-color: #d4edda; color: #155724; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
                    <?php echo htmlspecialchars($message_succes); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($message_erreur)): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
                    <?php echo htmlspecialchars($message_erreur); ?>
                </div>
            <?php endif; ?>

            <form action="create_reparateur.php" method="POST">
                
                <div class="form-group">
                    <label for="nom">Nom de famille : <span class="required-star">*</span></label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom : <span class="required-star">*</span></label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="mail">Adresse email pro : <span class="required-star">*</span></label>
                    <input type="email" id="mail" name="mail" class="form-control" required placeholder="nom@repaircafe.fr">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe temporaire : <span class="required-star">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe : <span class="required-star">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; background-color: #28a745;">Créer le profil Staff</button>
                
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>