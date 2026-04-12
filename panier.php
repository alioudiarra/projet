<?php
session_start();
require_once 'database.php'; // Toujours besoin de $conn

$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - Leboncoin</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-cart { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">🛒 Votre Panier</h1>
        
        <?php if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])): ?>
            <div class="card p-5 text-center shadow-sm">
                <p class="lead">Votre panier est actuellement vide.</p>
                <a href="acceil.php" class="btn btn-danger w-25 m-auto">Retourner aux annonces</a>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Produit</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Nettoyage des IDs pour la sécurité
                        $ids = implode(',', array_map('intval', $_SESSION['panier']));
                        $sql = "SELECT * FROM annnonce WHERE id_a IN ($ids)";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)): 
                            $total += $row['price'];
                        ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($row['img']); ?>" class="img-cart" alt="Produit">
                                </td>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($row['title']); ?></span>
                                </td>
                                <td class="text-danger fw-bold">
                                    <?= number_format($row['price'], 0, ',', ' '); ?> €
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Total à régler :</th>
                            <th class="fs-5 text-danger"><?= number_format($total, 0, ',', ' '); ?> €</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="acceil.php" class="btn btn-outline-secondary">Continuer mes achats</a>
                <button class="btn btn-danger btn-lg">Procéder au paiement</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>