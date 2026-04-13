<?php
session_start();
if (isset($_GET['id_a'])) {
    $id_produit = $_GET['id_a'];
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }
    // On ajoute l'ID ici
    $_SESSION['panier'][] = $id_produit;
}
// Redirection TOUJOURS à la fin, en dehors des IF
header("Location: panier.php");
exit();
?>