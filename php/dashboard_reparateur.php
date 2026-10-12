<?php
session_start();

//On vérifie que c'est bien un REPARATEUR qui est connecté
if (!isset($_SESSION['reparateur_id'])) {
    header("Location: reparateur_connect.php");
    exit();
}

require_once 'db_connect.php';

$message_erreur = "";
$liste_requetes = [];

try {
    // On fait une jointure (JOIN) avec la table compte pour avoir le nom/prenom/mail
    // On utilise UNION ALL pour regrouper les réparations et les locations dans le même tableau
    $sql = "
        SELECT c.nom, c.prenom, c.mail, 'Réparation' AS type_demande, r.appareil AS detail_objet, r.description AS info_sup
        FROM reparation r
        INNER JOIN compte c ON r.compte_id = c.id_compte
        
        UNION ALL
        
        SELECT c.nom, c.prenom, c.mail, 'Location' AS type_demande, l.objet AS detail_objet, l.raison AS info_sup
        FROM location l
        INNER JOIN compte c ON l.compte_id = c.id_compte
    ";

    $stmt = $pdo->query($sql);
    $liste_requetes = $stmt->fetchAll();

} catch (PDOException $e) {
    $message_erreur = "Erreur lors de la récupération des requêtes : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Réparateur - Repair Café</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Quelques styles spécifiques pour le tableau d'administration */
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 2rem; background: white; }
        .admin-table th, .admin-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .admin-table th { background-color: var(--color-primary, #333); color: white; }
        .admin-table tr:hover { background-color: #f5f5f5; }
        .badge-repa { background: #e3f2fd; color: #0d47a1; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold;}
        .badge-loc { background: #e8f5e9; color: #1b5e20; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold;}
        .admin-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    </style>
</head>
<body>

    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-block">
                <img src="../img/logo_iut.png" alt="Logo" class="logo-img">
                <h2>Back-Office Réparateur</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="logout_reparateur.php" class="nav-link" style="color: red;">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="form-card" style="max-width: 1000px;"> <div class="admin-actions">
                <h1>Toutes les demandes clients</h1>
                <a href="create_reparateur.php" class="btn" style="background-color: #28a745;">+ Ajouter un réparateur</a>
            </div>

            <p style="margin-bottom: 0.5rem; font-weight: bold; color: var(--color-primary, #333);">
                Connecté en tant que : <?php echo htmlspecialchars($_SESSION['prenom_repa'] . " " . $_SESSION['nom_repa']); ?>
            </p>

            <?php if ($message_erreur): ?>
                <p style="color: red;"><?php echo $message_erreur; ?></p>
            <?php endif; ?>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Type de demande</th>
                        <th>Matériel concerné</th>
                        <th>Description / Motif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($liste_requetes) > 0): ?>
                        <?php foreach ($liste_requetes as $req): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($req['nom'] . " " . $req['prenom']); ?></td>
                                <td><a href="mailto:<?php echo htmlspecialchars($req['mail']); ?>"><?php echo htmlspecialchars($req['mail']); ?></a></td>
                                <td>
                                    <?php if ($req['type_demande'] === 'Réparation'): ?>
                                        <span class="badge-repa">Réparation</span>
                                    <?php else: ?>
                                        <span class="badge-loc">Location</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($req['detail_objet']); ?></td>
                                <td><?php echo htmlspecialchars($req['info_sup']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">Aucune demande n'a été trouvée dans la base de données.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </main>

</body>
</html>