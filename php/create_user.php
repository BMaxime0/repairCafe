<?php
require_once 'db_connect.php';

$message_erreur = ""; // Pour stocker les erreurs proprement

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $filiere = $_POST['filiere'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmation_password'];

    if ($password !== $confirm_password) {
        $message_erreur = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $requete = $pdo->prepare("INSERT INTO compte (nom, prenom, sexe, filiere, mail, password) VALUES (:nom, :prenom, :sexe, :filiere, :mail, :password)");
            $requete->execute([
                ":nom"      => $nom,
                ":prenom"   => $prenom,
                ":sexe"     => $sexe,
                ":filiere"  => $filiere,
                ":mail"     => $mail,
                ":password" => $password_hash
            ]);

            // Redirection immédiate (SANS ESPACE avant les :)
            header("Location: user_connect.php");
            exit();

        } catch (PDOException $e) {
            $message_erreur = "Erreur base de données : " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Inscription</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="../Acceuil.html" class="nav-link">Accueil</a></li>
                <li><a href="dashboard.php" class="nav-link active">Espace Service</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card">
            <h1>Créer un profil utilisateur</h1>
            
            <?php if(!empty($message_erreur)): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem;">
                    <?php echo htmlspecialchars($message_erreur); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="create_user.php">
                <div class="form-group">
                    <label for="nom">Nom de famille : <span class="required-star">*</span></label>
                    <input type="text" id="nom" name="nom" class="form-control" required placeholder="Votre nom">
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom : </label>
                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom">
                </div>

                <div class="form-group">
                    <label for="mail">Adresse e-mail : <span class="required-star">*</span></label>
                    <input type="email" id="mail" name="mail" class="form-control" required placeholder="nom@iut-rodez.fr">
                </div>

                <div class="form-group">
                    <label for="filiere">Filière / Département : </label>
                    <select name="filiere" id="filiere" class="form-control">
                        <option value="informatique">Informatique</option>
                        <option value="info_com">Information-Communication</option>
                        <option value="QLIO">QLIO</option>
                        <option value="Autre">Autre / Personnel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe : <span class="required-star">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirmation_password">Confirmation du mot de passe : <span class="required-star">*</span></label>
                    <input type="password" name="confirmation_password" id="confirmation_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Genre : <span class="required-star">*</span></label>
                    <div class="radio-group">
                        <label class="radio-label" for="sexeFemme">
                            <input type="radio" id="sexeFemme" name="sexe" value="Femme" required> Femme
                        </label>
                        <label class="radio-label" for="sexeHomme">
                            <input type="radio" id="sexeHomme" name="sexe" value="Homme" required> Homme
                        </label>
                        <label class="radio-label" for="sexeAutre">
                            <input type="radio" id="sexeAutre" name="sexe" value="Autre" required> Autre
                        </label>
                    </div>
                </div>

                <button type="submit" id="buttonVerif" class="btn" style="width: 100%; margin-top: 1.5rem;">Valider l'inscription</button>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>
