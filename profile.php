<?php
require_once 'config.php';
require_once 'database.php';

<<<<<<< HEAD
// Sécurité : Vérifier si l'utilisateur est connecté
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

=======
// Vérifier si l'utilisateur est connecté sinon il le renvoie vers la page de connexion
>>>>>>> 1d755ff12d490a5888c3bd6c0c56b021dea72410
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
} 

$id_u = (int) $_SESSION['id_u'];

<<<<<<< HEAD
// 1. Récupération des informations de l'utilisateur
=======
// Récup utilisateur
>>>>>>> 1d755ff12d490a5888c3bd6c0c56b021dea72410
$sql = "SELECT * FROM users WHERE id_u = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erreur SQL : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id_u);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Utilisateur introuvable.");
}

<<<<<<< HEAD
// 2. Récupération des annonces de l'utilisateur
=======
// Récup annonces
>>>>>>> 1d755ff12d490a5888c3bd6c0c56b021dea72410
$annonces = [];
$sqlAnnonces = "SELECT * FROM annnonce WHERE id_u = ? ORDER BY id_a DESC";
$stmtAnnonces = mysqli_prepare($conn, $sqlAnnonces);

if ($stmtAnnonces) {
    mysqli_stmt_bind_param($stmtAnnonces, "i", $id_u);
    mysqli_stmt_execute($stmtAnnonces);
    $resultAnnonces = mysqli_stmt_get_result($stmtAnnonces);

    while ($row = mysqli_fetch_assoc($resultAnnonces)) {
        $annonces[] = $row;
    }
}

// Fonction utilitaire pour l'admin

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil - Leboncoin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<<<<<<< HEAD

=======
>>>>>>> 1d755ff12d490a5888c3bd6c0c56b021dea72410
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

<section class="py-5" style="background-color: #f7f7f7; min-height: 100vh;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <img src="<?= !empty($user['photo_profil']) ? htmlspecialchars($user['photo_profil']) : 'avatar.jpg' ?>" 
                         class="rounded-circle mx-auto mb-3" width="110" height="110" style="object-fit: cover;">
                    <h3 class="fw-bold"><?= htmlspecialchars($user['nom'] ?? 'Utilisateur') ?></h3>
                    <a href="update-profile.php" class="btn btn-danger w-100 rounded-3">Modifier profil</a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h2 class="fw-bold mb-4">Informations personnelles</h2>
                    <p class="mb-1 text-muted small fw-bold">EMAIL</p>
                    <p class="fw-semibold border-bottom pb-2"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    
                    <p class="mb-1 text-muted small fw-bold">VILLE</p>
                    <p class="fw-semibold border-bottom pb-2"><?= !empty($user['ville']) ? htmlspecialchars($user['ville']) : 'Non renseignée' ?></p>

                    <p class="mb-1 text-muted small fw-bold mt-3">MA BIO</p>
                    <div class="p-3 rounded-3" style="background-color: #f8f9fa; border-left: 4px solid #dc3545;">
                        <p class="mb-0">
                            <?= !empty($user['bio']) ? nl2br(htmlspecialchars($user['bio'])) : '<i>Aucune bio rédigée.</i>' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
    <h2 class="fw-bold text-center mb-4">Mes annonces</h2>
    <?php if (!empty($annonces)) : ?>
        <div id="carouselProduits" class="carousel slide" data-bs-ride="carousel">
            
            <div class="carousel-inner">
                <?php foreach ($annonces as $index => $annonce) : ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-6 text-center p-4" style="background-color: #eef3f7;">
                                    <img src="<?= htmlspecialchars($annonce['img']) ?>" class="img-fluid" style="max-height: 250px;">
                                </div>
                                <div class="col-md-6 p-4">
                                    <h3 class="fw-bold"><?= htmlspecialchars($annonce['title']) ?></h3>
                                    <p class="text-danger fs-3 fw-bold"><?= number_format((float)$annonce['price'], 2, ',', ' ') ?> €</p>
                                    <a href="article.php?id=<?= $annonce['id_a'] ?>" class="btn btn-dark">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduits" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduits" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>

        </div>
    <?php else : ?>
        <p class="text-center text-muted">Aucune annonce.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>