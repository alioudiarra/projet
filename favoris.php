<?php
session_start();
require_once 'database.php';

// Sécurité : Seul un membre connecté peut voir ses favoris [cite: 8, 44]
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
}

$id_u = $_SESSION['id_u'];

// Requête avec JOINTURE (INNER JOIN) pour lier les likes aux détails des annonces [cite: 19]
$sql = "SELECT a.* FROM annnonce a 
        INNER JOIN `like` l ON a.id_a = l.id_a 
        WHERE l.id_u = ? 
        ORDER BY a.id_a DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_u);
mysqli_stmt_execute($stmt);
$resultat = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Favoris - Leboncoin ECE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <div class="container mt-5">
        <h2 class="mb-4">❤️ Mes annonces favorites</h2>
        
        <div class="row">
            <?php if (mysqli_num_rows($resultat) > 0): ?>
                <?php while ($annonce = mysqli_fetch_assoc($resultat)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?= htmlspecialchars($annonce['img']) ?>" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <p class="text-danger fw-bold"><?= number_format($annonce['price'], 2, ',', ' ') ?> €</p>
                                <div class="d-flex justify-content-between">
                                    <a href="article.php?id=<?= $annonce['id_a'] ?>" class="btn btn-sm btn-dark">Voir</a>
                                    <a href="#?id_a=<?= $annonce['id_a'] ?>" class="text-danger">
                                        <i class="bi bi-heart-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">Vous n'avez pas encore de favoris.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>