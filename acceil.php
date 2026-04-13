<?php
// 1. CONNEXION ET SESSION
require_once 'config.php'; 
require_once 'database.php'; 

// 2. RÉCUPÉRATION DES PRODUITS POPULAIRES (LES 6 PREMIERS)
$sqlPop = "SELECT * FROM annnonce LIMIT 6"; 
$resultPop = mysqli_query($conn, $sqlPop);

// 3. RÉCUPÉRATION DES ANNONCES VENDEURS (SAUF LES 6 PREMIERS)
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
<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top shadow-sm bg-white">
    <div class="container">
        <a class="navbar-brand brand-logo" href="acceil.php">
            <span class="text-danger fw-bold">lebon</span>coin
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

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item text-danger fw-bold" href="#">
                                Voir tout
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="a-propos-de-nous.html">
                        À propos de nous
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">
                        Contact
                    </a>
                </li>

                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="admin.php">
                            <i class="bi bi-shield-lock-fill"></i> Admin
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

            <!-- 🔍 Barre de recherche -->
            <form class="d-flex me-3" method="GET" action="recherche.php">
                <input 
                    class="form-control" 
                    type="search" 
                    name="q" 
                    placeholder="Rechercher..."
                >

                <button class="btn btn-danger ms-2" type="submit">
                    OK
                </button>
            </form>

            <!-- 👤 Icônes utilisateur -->
            <div class="d-flex align-items-center gap-3">

                <?php if (isset($_SESSION['id_u'])): ?>

<<<<<<< HEAD
//NAVBAR
=======
                    <a class="icon-btn d-flex align-items-center gap-2 text-decoration-none text-dark" href="profile.php">
                        <i class="bi bi-person-fill text-danger"></i>
>>>>>>> 3882add5ad0d3962531e4e099c309bb0299b805c

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

                <!-- 🛒 Panier -->
                <a class="icon-btn" href="panier.php">
                    <i class="bi bi-bag"></i>
                </a>

                <!-- ❤️ Favoris (UN SEUL maintenant) -->
                <a class="nav-link p-0 fw-bold text-danger" href="favoris.php">
                    Mes favoris
                </a>

            </div>

<<<<<<< HEAD
<li>
<a class="dropdown-item" href="smartphone.php">
 Smartphones et Montre 
</a>
</li>

<li>
<a class="dropdown-item" href="informatique.php">
💻 Informatique
</a>
</li>

<li>
<a class="dropdown-item" href="console.php">
 Gaming
</a>
</li>

<li>
<a class="dropdown-item" href="casque.php">
Audio & Casques
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

//Admin

<?php if (function_exists('isAdmin') && isAdmin()): ?>

<li class="nav-item">
<a class="nav-link text-danger fw-bold" href="admin.php">
<i class="bi bi-shield-lock-fill"></i> Admin
</a>
</li>

<?php endif; ?>

</ul>

 //Partie droite 

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

// CONTENU FAVORIS

<div class="container mt-5">

<h2 class="mb-4"> Mes annonces favorites</h2>

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
=======
        </div>
    </div>
</nav>
>>>>>>> 3882add5ad0d3962531e4e099c309bb0299b805c
<div id="heroCarousel" class="carousel slide container mt-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    </div>
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
        <div class="carousel-item">
            <div class="card border-0 shadow-lg p-4">
                <div class="row flex-lg-row-reverse align-items-center g-5">
                    <div class="col-lg-6"><img src="IMG/AirPods-Max-5-600x600.png" class="img-fluid"></div>
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold mb-3">Audio Premium</h1>
                        <p class="lead">Le meilleur du son pour vos oreilles.</p>
                        <button class="btn btn-danger btn-lg">Découvrir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" style="filter: invert(1);"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" style="filter: invert(1);"></span>
    </button>
</div>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Produits populaires</h2>
    <div class="row g-4">
        <?php while ($pop = mysqli_fetch_assoc($resultPop)) : 
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
                    <a href="ajouter_favoris.php?id_a=<?= $pop['id_a']; ?>">
                        <i class="bi <?= $isLikedPop ? 'bi-heart-fill' : 'bi-heart'; ?> text-danger fs-4"></i>
                    </a>
                </div>
                <img src="<?= $pop['img']; ?>" class="card-img-top p-3" style="height: 200px; object-fit: contain;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold"><?= htmlspecialchars($pop['title']); ?></h5>
                    <p class="text-danger fw-bold fs-5"><?= number_format($pop['price'], 0, ',', ' '); ?>€</p>
                    <a href="ajouter_panier.php?id_a=<?php echo (int)$pop['id_a']; ?>" class="btn btn-danger w-100 rounded-pill">Ajouter au panier</a>               
           </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Dernières annonces</h2>
    <div class="row g-4">
       <?php while ($row = mysqli_fetch_assoc($resultVendeurs)) : 
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
                    <a href="ajouter_favoris.php?id_a=<?= $row['id_a']; ?>">
                        <i class="bi <?= $isLiked ? 'bi-heart-fill' : 'bi-heart'; ?> text-danger fs-4"></i>
                    </a>
                </div>
                <div style="height: 180px; display: flex; align-items: center; justify-content: center;">
                    <img src="<?= $row['img']; ?>" class="card-img-top p-2" style="max-height: 100%; width: auto; object-fit: contain;">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold"><?= htmlspecialchars($row['title']); ?></h5>
                    <p class="text-danger fw-bold fs-5"><?= number_format($row['price'], 0, ',', ' '); ?>€</p>
                    <a href="article.php?id=<?= $row['id_a']; ?>" class="btn btn-outline-danger w-100 rounded-pill">Voir l'annonce</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row">
            <div class="col-md-3 mt-3">
                <h5 class="text-uppercase fw-bold mb-4"><span style="color:red;">lebon</span>coin</h5>
                <p>Votre boutique tech en ligne préférée pour trouver les meilleures pépites informatiques et mobiles.</p>
            </div>
            <div class="col-md-2 mt-3">
                <h5 class="text-uppercase fw-bold mb-4">Produits</h5>
                <p><a href="smartphone.php" class="text-light text-decoration-none">Téléphones</a></p>
                <p><a href="casque.php" class="text-light text-decoration-none">Casques</a></p>
                <p><a href="informatique.php" class="text-light text-decoration-none">Informatique</a></p>
            </div>
            <div class="col-md-3 mt-3">
                <h5 class="text-uppercase fw-bold mb-4">Liens utiles</h5>
                <p><a href="profile.php" class="text-light text-decoration-none">Votre Compte</a></p>
                <p><a href="favoris.php" class="text-light text-decoration-none">Mes Favoris</a></p>
                <p><a href="contact.php" class="text-light text-decoration-none">Aide & Support</a></p>
            </div>
            <div class="col-md-4 mt-3">
                <h5 class="text-uppercase fw-bold mb-4">Contact</h5>
                <p><i class="bi bi-house me-2"></i> Paris, 75015 France</p>
                <p><i class="bi bi-envelope me-2"></i> contact@leboncoin.com</p>
                <p><i class="bi bi-phone me-2"></i> +33 1 23 45 67 89</p>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <p>© 2026 Copyright : <strong>LEBONCOIN - GRP 4 ECE</strong></p>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="#" class="text-light me-4 fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-4 fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-light me-4 fs-4"><i class="bi bi-twitter-x"></i></a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>