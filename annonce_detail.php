<?php
require_once 'config.php';
require_once 'database.php';

$id_a = (int)($_GET['id'] ?? 0);

if ($id_a === 0) {
    header("Location: index.php");
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
    header("Location: index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($annonce['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
  <div class="container">
    <a class="navbar-brand brand-logo" href="#">
      <span>lebon</span>coin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-3 me-auto gap-lg-3">
        <li class="nav-item"><a class="nav-link" href="acceil.php">Accueil</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Vente</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="smartphone.php">📱 Smartphones et Montre ⌚️</a></li>
            <li><a class="dropdown-item" href="informatique.php">💻 Informatique</a></li>
            <li><a class="dropdown-item" href="console.php">🎮 Gaming</a></li>
            <li><a class="dropdown-item" href="casque.php">🎧 Audio & Casques</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger fw-bold" href="#categories">Voir tout</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="a-propos-de-nous.php">À propos de nous</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <?php if (isAdmin()): ?>
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="admin.php">
              <i class="bi bi-shield-lock-fill"></i> Admin
            </a>
          </li>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center gap-3">
        <?php if (isset($_SESSION['id_u'])): ?>
          <a class="icon-btn d-flex align-items-center gap-2" href="profile.php">
            <i class="bi bi-person-fill text-danger"></i>
            <span class="fw-semibold small"><?= htmlspecialchars($_SESSION['pseudo'] ?? '') ?></span>
          </a>
          <a class="icon-btn" href="deconnexion.php"><i class="bi bi-box-arrow-right"></i></a>
        <?php else: ?>
          <a class="icon-btn" href="inscription.php"><i class="bi bi-person"></i></a>
        <?php endif; ?>
        <a class="icon-btn" href="#"><i class="bi bi-search"></i></a>
        <a class="icon-btn" href="#"><i class="bi bi-bag"></i></a>
      </div>
    </div>
  </div>
</nav>

<!-- ===== DÉTAIL ANNONCE ===== -->
<div class="container py-5">

    <a href="javascript:history.back()" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <div class="row g-5">

        <!-- Image -->
        <div class="col-lg-6">
            <?php if (!empty($annonce['img'])): ?>
                <img src="<?= htmlspecialchars($annonce['img']) ?>" 
                     class="img-fluid rounded-4 shadow w-100" 
                     style="max-height: 500px; object-fit: cover;"
                     alt="<?= htmlspecialchars($annonce['title']) ?>">
            <?php else: ?>
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center shadow" style="height: 400px;">
                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                </div>
            <?php endif; ?>
        </div>

        <!-- Infos -->
        <div class="col-lg-6">
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($annonce['title']) ?></h1>

            <p class="text-danger fw-bold fs-2 mb-3">
                <?= number_format($annonce['price'], 2) ?> €
            </p>

            <span class="badge bg-<?= $couleurs[$s] ?? 'secondary' ?> fs-6 mb-3">
                État : <?= $statuts[$s] ?? 'Inconnu' ?>
            </span>

            <hr>

            <h5 class="fw-bold">Description</h5>
            <p class="text-muted"><?= nl2br(htmlspecialchars($annonce['desc'])) ?></p>

            <hr>

            <p class="mb-4">
                <strong>Vendeur :</strong> <?= htmlspecialchars($annonce['vendeur']) ?>
            </p>

            <!-- Bouton contacter -->
            <?php if (isset($_SESSION['id_u'])): ?>
                <a href="contact_vendeur.php?id_u=<?= (int)$annonce['id_u'] ?>&id_a=<?= (int)$annonce['id_a'] ?>" 
                   class="btn btn-primary w-100 mb-3 py-3 fs-5">
                    Contacter le vendeur
                </a>
              
            <?php else: ?>
                <a href="connexion.php" class="btn btn-primary w-100 mb-3 py-3 fs-5">
                    Connectez-vous pour contacter le vendeur
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>