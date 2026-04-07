<?php

session_start();
require_once 'database.php';

// Sécurité
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
}

$id_u = $_SESSION['id_u'];

// Requête favoris
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
<title>Mes Favoris</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="style.css">

</head>

<body>

<!-- NAVBAR DIRECTEMENT ICI -->

<!-- NAVBAR -->

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

<li class="nav-item">
<a class="nav-link active" href="acceil.php">Accueil</a>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
Vente
</a>

<ul class="dropdown-menu">

<li>
<a class="dropdown-item" href="smartphone.php">
📱 Smartphones et Montre ⌚️
</a>
</li>

<li>
<a class="dropdown-item" href="informatique.php">
💻 Informatique
</a>
</li>

<li>
<a class="dropdown-item" href="console.php">
🎮 Gaming
</a>
</li>

<li>
<a class="dropdown-item" href="casque.php">
🎧 Audio & Casques
</a>
</li>

<li><hr class="dropdown-divider"></li>

<li>
<a class="dropdown-item text-danger fw-bold" href="#categories">
Voir tout
</a>
</li>

</ul>
</li>

<li class="nav-item">
<a class="nav-link" href="a-propos-de-nous.php">
À propos de nous
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">
Blog
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="contact.php">
Contact
</a>
</li>

<!-- Admin -->

<?php if (function_exists('isAdmin') && isAdmin()): ?>

<li class="nav-item">
<a class="nav-link text-danger fw-bold" href="admin.php">
<i class="bi bi-shield-lock-fill"></i> Admin
</a>
</li>

<?php endif; ?>

</ul>

<!-- Partie droite -->

<div class="d-flex align-items-center gap-3">

<?php if (isset($_SESSION['id_u'])): ?>

<a class="icon-btn d-flex align-items-center gap-2" href="profile.php">
<i class="bi bi-person-fill text-danger"></i>
<span class="fw-semibold small">
<?= htmlspecialchars($_SESSION['pseudo'] ?? '') ?>
</span>
</a>

<a class="icon-btn" href="deconnexion.php">
<i class="bi bi-box-arrow-right"></i>
</a>

<?php else: ?>

<a class="icon-btn" href="inscription.php">
<i class="bi bi-person"></i>
</a>

<?php endif; ?>

<a class="icon-btn" href="#">
<i class="bi bi-search"></i>
</a>

<a class="icon-btn" href="#">
<i class="bi bi-bag"></i>
</a>

<a class="nav-link p-0" href="favoris.php">
Mes favoris
</a>

</div>

</div>
</div>
</nav>

<!-- CONTENU FAVORIS -->

<div class="container mt-5">

<h2 class="mb-4">❤️ Mes annonces favorites</h2>

<div class="row">

<?php if (mysqli_num_rows($resultat) > 0): ?>

<?php while ($annonce = mysqli_fetch_assoc($resultat)): ?>

<div class="col-md-4 mb-4">

<div class="card shadow-sm">

<img src="<?= htmlspecialchars($annonce['img']) ?>" 
class="card-img-top">

<div class="card-body">

<h5 class="card-title">
<?= htmlspecialchars($annonce['title']) ?>
</h5>

<p class="text-danger fw-bold">
<?= number_format($annonce['price'], 2, ',', ' ') ?> €
</p>

<a href="article.php?id=<?= $annonce['id_a'] ?>" 
class="btn btn-dark btn-sm">
Voir
</a>

</div>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="alert alert-info">
Vous n'avez pas encore de favoris.
</div>

<?php endif; ?>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>