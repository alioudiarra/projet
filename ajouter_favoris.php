<?php
session_start();
require_once 'database.php';

if (isset($_GET['id_a']) && isset($_SESSION['id_u'])) {
    $id_a = (int)$_GET['id_a'];
    $id_u = $_SESSION['id_u'];

    // Vérifier si le like existe déjà
    $check = mysqli_prepare($conn, "SELECT * FROM `like` WHERE id_u = ? AND id_a = ?");
    mysqli_stmt_bind_param($check, "ii", $id_u, $id_a);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) > 0) {
        // Supprimer (Retirer des favoris)
        $sql = "DELETE FROM `like` WHERE id_u = ? AND id_a = ?";
    } else {
        // Insérer (Ajouter aux favoris)
        $sql = "INSERT INTO `like` (id_u, id_a) VALUES (?, ?)";
    }
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_u, $id_a);
    mysqli_stmt_execute($stmt);
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();