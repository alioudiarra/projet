<?php
require_once 'config.php';
require_once 'database.php';

// Récupérer les annonces de type informatique
$annonces = [];
// Mise à jour de la requête pour cibler l'informatique
$sql = "SELECT * FROM annnonce WHERE type = 'ordinateur' OR type = 'composant' OR type = 'peripherique' ORDER BY id_a DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $annonces[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatique - LEBONCOIN GRP 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light py-3 sticky-top shadow-sm bg-white">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="acceil.php">
            <span class="text-danger">lebon</span>coin
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="acceil.php">Accueil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Vente</a>
                    <ul class="dropdown-menu border-0 shadow-sm">
                        <li><a class="dropdown-item" href="smartphone.php">📱 Smartphones & Montres</a></li>
                        <li><a class="dropdown-item" href="informatique.php">💻 Informatique</a></li>
                        <li><a class="dropdown-item" href="console.php">🎮 Gaming</a></li>
                        <li><a class="dropdown-item" href="casque.php">🎧 Audio & Casques</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a-propos-de-nous.php">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="admin.php">
                            <i class="bi bi-shield-lock-fill"></i> Admin
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <form class="d-flex me-lg-4" method="GET" action="recherche.php">
                <div class="input-group">
                    <input class="form-control border-danger-subtle" type="search" name="q" placeholder="Rechercher un produit...">
                    <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <a class="text-dark position-relative" href="messagerie.php" title="Messages">
                    <i class="bi bi-chat-dots fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </a>

                <a class="text-dark" href="favoris.php" title="Mes favoris">
                    <i class="bi bi-heart fs-4"></i>
                </a>

                <a class="text-dark" href="panier.php" title="Mon panier">
                    <i class="bi bi-bag fs-4"></i>
                </a>

                <div class="ms-2 border-start ps-3 d-flex align-items-center">
                    <?php if (isset($_SESSION['id_u'])): ?>
                        <div class="dropdown">
                            <a class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4 text-danger me-2"></i>
                                <span class="fw-semibold small d-none d-xl-inline"><?= htmlspecialchars($_SESSION['pseudo'] ?? 'Mon Compte') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="deconnexion.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-outline-danger btn-sm rounded-pill px-3" href="inscription.php">Connexion</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <p class="text-danger fw-bold text-uppercase mb-2">Catégorie</p>
        <h1 class="fw-bold display-5 mb-2">💻 Informatique</h1>
        <p class="text-muted">PC, ordinateurs portables, composants et périphériques</p>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center">Annonce ajoutée avec succès !</div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="col-sm-6 col-lg-4">
                    <a href="annonce_detail.php?id=<?= (int)$annonce['id_a'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0 rounded-4">

                            <?php if (!empty($annonce['img'])): ?>
                                <img src="<?= htmlspecialchars($annonce['img']) ?>"
                                     class="card-img-top rounded-top-4"
                                     style="height: 220px; object-fit: cover;"
                                     alt="<?= htmlspecialchars($annonce['title']) ?>">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height: 220px;">
                                    <i class="bi bi-pc-display text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <span class="badge bg-danger mb-2"><?= htmlspecialchars($annonce['type']) ?></span>
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <p class="card-text text-muted small"><?= htmlspecialchars($annonce['desc']) ?></p>
                            </div>

                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center pb-3">
                                <span class="fw-bold text-danger fs-5"><?= number_format($annonce['price'], 2) ?> €</span>
                                <?php
                                    $statuts  = [1 => 'Disponible', 2 => 'Vendu', 3 => 'Réservé'];
                                    $couleurs = [1 => 'success', 2 => 'secondary', 3 => 'warning'];
                                    $s = $annonce['status'];
                                ?>
                                <span class="badge bg-<?= $couleurs[$s] ?? 'secondary' ?>">
                                    <?= $statuts[$s] ?? 'Inconnu' ?>
                                </span>
                            </div>

                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <i class="bi bi-pc-display text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted fs-5 mt-3">Aucune annonce informatique pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>