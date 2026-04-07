
<?php
// 1. CONNEXION ET SESSION
require_once 'config.php'; 
require_once 'database.php'; 

// 2. RÉCUPÉRATION DES PRODUITS POPULAIRES (LES 6 PREMIERS)
$sqlPop = "SELECT * FROM annnonce LIMIT 6"; 
$resultPop = mysqli_query($conn, $sqlPop);

// 3. RÉCUPÉRATION DES ANNONCES VENDEURS (SAUF LES 6 PREMIERS)
// On utilise OFFSET 6 pour sauter les produits déjà affichés en haut
$sqlVendeurs = "SELECT * FROM annnonce ORDER BY id_a DESC LIMIT 100 OFFSET 6";
$resultVendeurs = mysqli_query($conn, $sqlVendeurs);
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





<?php


require_once 'database.php';

// Sécurité : utilisateur connecté obligatoire
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
<title>Mes Favoris - Leboncoin ECE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

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
class="card-img-top" 
alt="Image">

<div class="card-body">

<h5 class="card-title">
<?= htmlspecialchars($annonce['title']) ?>
</h5>

<p class="text-danger fw-bold">
<?= number_format($annonce['price'], 2, ',', ' ') ?> €
</p>

<div class="d-flex justify-content-between">

<a href="article.php?id=<?= $annonce['id_a'] ?>" 
class="btn btn-sm btn-dark">
Voir
</a>

<a href="#?id_a=<?= $annonce['id_a'] ?>" 
class="text-danger">

<i class="bi bi-heart-fill"></i>

</a>

</div>

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

<!-- HERO CAROUSEL -->

<div id="heroCarousel" class="carousel slide container mt-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="card border-0 shadow-lg p-4">
                <div class="row flex-lg-row-reverse align-items-center g-5">
                    <div class="col-lg-6"><img src="IMG/d4bbced5-3174-492f-b45d-f3fb22565a02-1_c7854bef-96b0-48f2-acd4-72d8ee183e25.avif" class="img-fluid"></div>
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold mb-3">Design & Technologie</h1>
                        <p class="lead">Découvrez le smartphone nouvelle génération.</p>
                        <button class="btn btn-danger btn-lg">Achetez maintenant</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="promo-card promo-dark">
                <div class="promo-content"><small>Profiter</small><h3>Avec</h3><div class="promo-bgword">AirPods</div><a class="btn btn-danger btn-sm rounded-pill px-4 mt-3">Parcourir</a></div>
                <img class="promo-img" src="IMG/AirPods-Max-5-600x600.png">
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="promo-card promo-yellow">
                <div class="promo-content"><small>Nouveau</small><h3>Porter</h3><div class="promo-bgword">GADGET</div><a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a></div>
                <img class="promo-img" src="IMG/pngegg.png">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="promo-card promo-red">
                <div class="promo-content"><small>S'orienter</small><h3>Appareils</h3><div class="promo-bgword">LAPTOP</div><a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a></div>
                <img class="promo-img" src="IMG/pngegg (2).png">
            </div>
        </div>
    </div>
</div>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Produits populaires</h2>
    <div class="row g-4">
        <?php while ($pop = mysqli_fetch_assoc($resultPop)) {
            $isLikedPop = false;
            if (isset($_SESSION['id_u'])) {
                $check = mysqli_prepare($conn, "SELECT * FROM `like` WHERE id_u = ? AND id_a = ?");
                mysqli_stmt_bind_param($check, "ii", $_SESSION['id_u'], $pop['id_a']);
                mysqli_stmt_execute($check);
                if (mysqli_num_rows(mysqli_stmt_get_result($check)) > 0) $isLikedPop = true;
            }
        ?>
        <div class="col-lg-4 col-md-6"> 
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                    <a href="ajouter_favoris.php?id_a=<?php echo $pop['id_a']; ?>">
                        <i class="bi <?php echo $isLikedPop ? 'bi-heart-fill' : 'bi-heart'; ?> text-danger fs-4"></i>
                    </a>
                </div>
                <img src="<?php echo $pop['img']; ?>" class="card-img-top p-3" style="height: 200px; object-fit: contain;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($pop['title']); ?></h5>
                    <p class="text-danger fw-bold fs-5"><?php echo number_format($pop['price'], 0, ',', ' '); ?>€</p>
                    <button class="btn btn-danger w-100 rounded-pill">Ajouter au panier</button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold" style="color: #2c3e50;">Dernières annonces de nos vendeurs</h2>
    <div class="row g-4">
       <?php if (mysqli_num_rows($resultVendeurs) > 0) {
            while ($row = mysqli_fetch_assoc($resultVendeurs)) {
                $isLiked = false;
                if (isset($_SESSION['id_u'])) {
                    $checkLike = mysqli_prepare($conn, "SELECT * FROM `like` WHERE id_u = ? AND id_a = ?");
                    mysqli_stmt_bind_param($checkLike, "ii", $_SESSION['id_u'], $row['id_a']);
                    mysqli_stmt_execute($checkLike);
                    if (mysqli_num_rows(mysqli_stmt_get_result($checkLike)) > 0) $isLiked = true;
                } 
        ?>  
        <div class="col-lg-3 col-md-6 mb-4"> 
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;"> 
                    <a href="ajouter_favoris.php?id_a=<?php echo $row['id_a']; ?>">
                        <i class="bi <?php echo $isLiked ? 'bi-heart-fill' : 'bi-heart'; ?> text-danger fs-4"></i>
                    </a>
                </div>
                <div style="height: 180px; display: flex; align-items: center; justify-content: center;">
                    <img src="<?php echo $row['img']; ?>" class="card-img-top p-2" style="max-height: 100%; width: auto; object-fit: contain;">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="text-muted small"><?php echo htmlspecialchars($row['type']); ?></p>
                    <p class="text-danger fw-bold fs-5"><?php echo number_format($row['price'], 0, ',', ' '); ?>€</p>
                    <a href="article.php?id=<?php echo $row['id_a']; ?>" class="btn btn-outline-danger w-100 rounded-pill">Voir l'annonce</a>
                </div>
            </div>
        </div>
        <?php } } else { echo "<p class='text-center text-muted w-100'>Aucune autre annonce.</p>"; } ?>
    </div>
</section>

<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row">
            <div class="col-md-3 mt-3">
                <h5 class="text-uppercase fw-bold mb-4"><span style="color:red;">lebon</span>coin</h5>
                <p>Votre boutique tech en ligne.</p>
            </div>
            <div class="col-md-2 mt-3">
                <h5 class="text-uppercase fw-bold mb-4">Produits</h5>
                <p><a href="#" class="text-light text-decoration-none">Téléphones</a></p>
                <p><a href="#" class="text-light text-decoration-none">Casques</a></p>
            </div>
            <div class="col-md-4 mt-3">
                <h5 class="text-uppercase fw-bold mb-4">Contact</h5>
                <p><i class="bi bi-house"></i> Paris, France</p>
                <p><i class="bi bi-envelope"></i> contact@leboncoin.com</p>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <p>© 2026 Copyright : <strong>LEBONCOIN</strong></p>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="#" class="text-light me-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-4"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 