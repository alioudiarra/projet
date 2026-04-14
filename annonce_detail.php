<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$id_a = (int)($_GET['id'] ?? 0);

if ($id_a === 0) {
    header("Location: acceil.php");
    exit();
}

// Récupérer l'annonce
$sql = "SELECT a.*, u.nom AS vendeur FROM annnonce a 
        JOIN users u ON a.id_u = u.id_u 
        WHERE a.id_a = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_a);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$annonce = mysqli_fetch_assoc($result);

if (!$annonce) {
    header("Location: acceil.php");
    exit();
}

$statuts  = [1 => 'Disponible', 2 => 'Vendu', 3 => 'Réservé'];
$couleurs = [1 => 'success',    2 => 'secondary', 3 => 'warning'];
$s = $annonce['status'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($annonce['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <a href="javascript:history.back()" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <div class="row g-5">
        <div class="col-lg-6">
            <?php if (!empty($annonce['img'])): ?>
                <img src="<?= htmlspecialchars($annonce['img']) ?>" class="img-fluid rounded-4 shadow w-100" style="max-height: 500px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center shadow" style="height: 400px;">
                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-6">
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($annonce['title']) ?></h1>
            <p class="text-danger fw-bold fs-2 mb-3"><?= number_format($annonce['price'], 2) ?> €</p>
            <span class="badge bg-<?= $couleurs[$s] ?? 'secondary' ?> fs-6 mb-3">État : <?= $statuts[$s] ?? 'Inconnu' ?></span>
            <hr>
            <h5 class="fw-bold">Description</h5>
            <p class="text-muted"><?= nl2br(htmlspecialchars($annonce['desc'])) ?></p>
            <hr>
            <p class="mb-4"><strong>Vendeur :</strong> <?= htmlspecialchars($annonce['vendeur']) ?></p>

            <?php if (isset($_SESSION['id_u'])): ?>
                <?php if ($_SESSION['id_u'] != $annonce['id_u']): ?>
                    <a href="init_chat.php?id_a=<?= $annonce['id_a'] ?>&id_vendeur=<?= $annonce['id_u'] ?>" 
                       class="btn btn-danger w-100 py-3 fs-5 fw-bold">
                        <i class="bi bi-chat-dots"></i> Contacter le vendeur
                    </a>
                <?php else: ?>
                    <div class="alert alert-info text-center">C'est votre annonce.</div>
                <?php endif; ?>
            <?php else: ?>
                <a href="connexion.php" class="btn btn-primary w-100 py-3 fs-5">
                    Connectez-vous pour contacter le vendeur
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>