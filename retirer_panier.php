<?php
session_start();

if (isset($_GET['id_a'])) {
    $id_a = $_GET['id_a'];

    // On cherche l'ID dans le tableau du panier
    if (($key = array_search($id_a, $_SESSION['panier'])) !== false) {
        // Si on le trouve, on le supprime
        unset($_SESSION['panier'][$key]);
        
        // Optionnel : on réindexe le tableau pour éviter des "trous"
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    }
}

// On renvoie l'utilisateur vers le panier
header("Location: panier.php");
exit();
?>