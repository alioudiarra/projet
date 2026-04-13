<?php
session_start(); // On récupère la session actuelle
session_unset(); // On vide toutes les variables de session (pseudo, id_u, etc.)
session_destroy(); // On détruit physiquement le fichier de session sur le serveur

// On redirige immédiatement vers la page de connexion
header("Location: connexion.php"); 
exit(); // Très important pour arrêter l'exécution du script
?>