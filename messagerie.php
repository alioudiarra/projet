<?php
session_start();
require_once 'database.php';

// Sécurité de base : si pas connecté, retour à la connexion
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
}

$my_id = (int)$_SESSION['id_u'];

// TA REQUÊTE "ÉCOLE" (Affiche tout pour éviter les bugs de démo)
$sql = "SELECT c.id_c, c.id_u1, c.id_u2, a.title, a.img 
        FROM convers c 
        JOIN annnonce a ON c.id_a = a.id_a 
        ORDER BY c.id_c DESC";

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Messages - LEBONCOIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .conv-card {
            transition: all 0.2s;
            border-left: 5px solid transparent;
        }
        .conv-card:hover {
            background-color: #f1f1f1 !important;
            border-left: 5px solid #ff4e00; /* Couleur orange Leboncoin */
        }
        .img-annonce {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Messages</h2>
                <span class="badge bg-secondary">Connecté ID: <?= $my_id ?></span>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <?php if (mysqli_num_rows($res) > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php while($row = mysqli_fetch_assoc($res)): ?>
                                <a href="chat.php?id_c=<?= $row['id_c'] ?>" class="list-group-item list-group-item-action p-3 conv-card border-bottom">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $row['img'] ?>" class="img-annonce me-3" alt="Produit">
                                        
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($row['title']) ?></h6>
                                            
                                            <p class="mb-0 small text-muted">
                                                <?php if($row['id_u1'] == $my_id): ?>
                                                    <span class="badge bg-primary-subtle text-primary">Acheteur</span> Vous avez contacté le vendeur
                                                <?php elseif($row['id_u2'] == $my_id): ?>
                                                    <span class="badge bg-success-subtle text-success">Vendeur</span> Un acheteur vous a écrit
                                                <?php else: ?>
                                                    <span class="badge bg-light text-dark border">Vue Globale</span> Discussion entre ID <?= $row['id_u1'] ?> et <?= $row['id_u2'] ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        
                                        <div class="ms-auto text-muted">
                                            <i class="bi bi-chevron-right"></i>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-5 text-center">
                            <i class="bi bi-chat-left-dots fs-1 text-muted"></i>
                            <p class="mt-3 text-muted">Aucune discussion trouvée dans la base de données.</p>
                            <a href="acceil.php" class="btn btn-primary mt-2">Retour à l'accueil</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <p class="text-center mt-4 small text-muted">Mode démonstration scolaire (Requête globale)</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>