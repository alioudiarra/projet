<?php
require_once 'database.php';

// Vérifier si un ID est bien présent dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; //recupere l'id de l'article

    // Sécuriser l'ID pour éviter les piratages
    $id = mysqli_real_escape_string($conn, $id);

    // Supprimer l'annonce dans la base
    $sql = "DELETE FROM annnonce WHERE id_a = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        // Redirection vers le profil après succès
        header('Location: profile.php?message=supprime');
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($conn);
    }
}
?>