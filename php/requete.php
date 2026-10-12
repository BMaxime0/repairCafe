<?php
session_start(); // Permet de récupérer les informations de session

//Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: user_connect.php");
    exit();
}

require_once 'db_connect.php';

$message_succes = "";
$message_erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération du type de requête
    $typeRequete = $_POST['typeRequete'] ?? '';
    $compte_id = $_SESSION['user_id']; //récupère l'id de la personne connectée

    if ($typeRequete === 'reparation') {
        // Traitement de la Réparation
        $appareil = trim($_POST['typeAppareil'] ?? '');
        $description = trim($_POST['descReparation'] ?? '');

        if (!empty($appareil) && !empty($description)) {
            try {
                $requete = $pdo->prepare("INSERT INTO reparation (compte_id, appareil, description) VALUES (:compte_id, :appareil, :description)");
                $requete->execute([
                    ":compte_id"   => $compte_id,
                    ":appareil"    => $appareil,
                    ":description" => $description
                ]);
                
                $message_succes = "Votre demande de réparation a bien été enregistrée avec succès !";
            } catch (PDOException $e) {
                $message_erreur = "Erreur lors de l'enregistrement de la réparation : " . $e->getMessage();
            }
        } else {
            $message_erreur = "Veuillez remplir tous les champs de la section réparation.";
        }

// --------------------------------- Séparation entre réparation et location --------------------------------------------------------------

    } elseif ($typeRequete === 'location') {
        // Traitement de la Location
        $objet = trim($_POST['typeObjet'] ?? '');
        $temps = trim($_POST['dureeLocation'] ?? '');
        $raison = trim($_POST['raisonLocation'] ?? '');

        if (!empty($objet) && !empty($temps) && !empty($raison)) {
            try {
                $requete = $pdo->prepare("INSERT INTO location (compte_id, objet, temps, raison) VALUES (:compte_id, :objet, :temps, :raison)");
                $requete->execute([
                    ":compte_id" => $compte_id,
                    ":objet"     => $objet,
                    ":temps"     => $temps,
                    ":raison"    => $raison
                ]);
                
                $message_succes = "Votre demande de location a bien été enregistrée avec succès !";
            } catch (PDOException $e) {
                $message_erreur = "Erreur lors de l'enregistrement de la location : " . $e->getMessage();
            }
        } else {
            $message_erreur = "Veuillez remplir tous les champs de la section location.";
        }
    } else {
        $message_erreur = "Veuillez sélectionner un type de requête valide.";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Requête - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../JS/requete.js" defer></script>
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Nouvelle Requête</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="../html/Acceuil.html" class="nav-link">Accueil</a></li>
                <li><a href="/php/dashboard.php" class="nav-link active">Espace Service</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card">
            <h1>Créer une demande</h1>
            <p style="margin-bottom: 2rem; font-size: 0.9rem; color: #666;">
                Les champs marqués d'une astérisque (<span class="required-star">*</span>) sont obligatoires.
            </p>

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
            
            <form method="POST" action="requete.php">
                
                <div class="form-group">
                    <label for="typeRequete">Type de requête : <span class="required-star">*</span></label>
                    <select id="typeRequete" name="typeRequete" class="form-control" required>
                        <option value="">-- Choisissez une option --</option>
                        <option value="reparation">Réparation de matériel</option>
                        <option value="location">Location de matériel</option>
                    </select>
                </div>

                <div id="sectionReparation" class="cache">
                    <fieldset>
                        <legend>Détails de la réparation</legend>
                        
                        <div class="form-group">
                            <label for="typeAppareil">Type d'appareil : <span class="required-star">*</span></label>
                            <select id="typeAppareil" name="typeAppareil" class="form-control req-reparation">
                                <option value="">-- Sélectionnez --</option>
                                <option value="Ordinateur">Ordinateur</option>
                                <option value="Telephone">Téléphone portable</option>
                                <option value="Console">Console de jeux</option>
                                <option value="Autre">Autre matériel</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="descReparation">Description du problème : <span class="required-star">*</span></label>
                            <textarea id="descReparation" name="descReparation" class="form-control req-reparation" rows="4" placeholder="Décrivez précisément la panne constatée, les symptômes ou l'historique du problème..."></textarea>
                        </div>
                    </fieldset>
                </div>

                <div id="sectionLocation" class="cache">
                    <fieldset>
                        <legend>Détails de la location</legend>
                        
                        <div class="form-group">
                            <label for="typeObjet">Type d'objet souhaité : <span class="required-star">*</span></label>
                            <input type="text" id="typeObjet" name="typeObjet" class="form-control req-location" placeholder="Ex: Ordinateur portable, câble HDMI, adaptateur...">
                        </div>
                        
                        <div class="form-group">
                            <label for="dureeLocation">Durée de l'emprunt : <span class="required-star">*</span></label>
                            <input type="text" id="dureeLocation" name="dureeLocation" class="form-control req-location" placeholder="Ex: 2 jours, 1 semaine...">
                        </div>
                        
                        <div class="form-group">
                            <label for="raisonLocation">Motif de la demande : <span class="required-star">*</span></label>
                            <textarea id="raisonLocation" name="raisonLocation" class="form-control req-location" rows="4" placeholder="Pour quelle raison avez-vous besoin temporairement de cet équipement ?"></textarea>
                        </div>
                    </fieldset>
                </div>
                
                <button type="submit" id="buttonVerif" class="btn" style="width: 100%; margin-top: 1rem;">Vérifier / Envoyer la demande</button>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Repair Café - IUT de Rodez</p>
    </footer>

</body>
</html>
