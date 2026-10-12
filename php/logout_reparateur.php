<?php
session_start(); // On charge la session existante pour pouvoir la manipuler

// 1. On vide toutes les variables de session
$_SESSION = array();

// 2. Si on souhaite détruire complètement la session (et le cookie associé)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. On détruit la session sur le serveur
session_destroy();

// 4. Redirection vers la page de connexion des réparateurs
header("Location: reparateur_connect.php");
exit();
?>