<?php
require_once 'database.php';

// 1. Vérifier si un ID est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Annonce non trouvée.");
}

$id_a = (int)$_GET['id']; // Sécurisation : on force le format en nombre entier

// 2. Requête pour récupérer les infos de cette annonce précise
$sql = "SELECT * FROM annnonce WHERE id_a = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_a);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$annonce = mysqli_fetch_assoc($result);

// 3. Vérifier si l'annonce existe vraiment
if (!$annonce) {
    die("Cette annonce n'existe pas ou a été supprimée.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($annonce['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($annonce['img']) ?>" class="img-fluid rounded shadow" alt="Image">
            </div>
            <div class="col-md-6">
                <h1><?= htmlspecialchars($annonce['title']) ?></h1>
                <h2 class="text-danger"><?= number_format($annonce['price'], 2, ',', ' ') ?> €</h2>
                <p class="mt-4"><?= nl2br(htmlspecialchars($annonce['desc'])) ?></p>
                <hr>
                <a href="acceil.php" class="btn btn-outline-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>