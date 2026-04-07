
<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>LEBONCOIN GRP 4</title>

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
        <li class="nav-item"><a class="nav-link active" href="acceil.php">Accueil</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Vente
          </a>
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

        <!-- Lien Admin visible seulement si perm = 1 -->
        <?php if (isAdmin()): ?>         
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="admin.php">
              <i class="bi bi-shield-lock-fill"></i> Admin
            </a>
          </li>
        <?php endif; ?>  
      </ul><!-- ← fermeture ul manquante -->

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>