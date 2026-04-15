<?php
// 1. CONNEXION ET SESSION
require_once 'config.php'; 
require_once 'database.php'; 

// 2. RÉCUPÉRATION DES PRODUITS POPULAIRES (LES 6 PREMIERS)
$sqlPop = "SELECT * FROM annnonce LIMIT 6"; 
$resultPop = mysqli_query($conn, $sqlPop);

// 3. RÉCUPÉRATION DES 5 DERNIÈRES ANNONCES POUR LE CAROUSEL DU BAS
$sqlDernieres = "SELECT * FROM annnonce ORDER BY id_a DESC LIMIT 5";
$resultDernieres = mysqli_query($conn, $sqlDernieres);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEBONCOIN GRP 4 - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .clickable-img {
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .clickable-img:hover {
            transform: scale(1.03);
        }
        .card-title a {
            transition: color 0.2s;
        }
        .card-title a:hover {
            color: #dc3545 !important;
        }
        /* Style pour harmoniser le nouveau carousel d'annonces */
        .annonce-carousel-img {
            height: 300px;
            object-fit: contain;
            background-color: #fdfdfd;
        }
    </style>
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
                <a href="annonce_detail.php?id=<?= $pop['id_a']; ?>">
                    <img src="<?= $pop['img']; ?>" class="card-img-top p-3 clickable-img" style="height: 200px; object-fit: contain;">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">
                        <a href="annonce_detail.php?id=<?= $pop['id_a']; ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($pop['title']); ?></a>
                    </h5>
                    <p class="text-danger fw-bold fs-5"><?= number_format($pop['price'], 0, ',', ' '); ?>€</p>
                    <a href="ajouter_panier.php?id_a=<?php echo (int)$pop['id_a']; ?>" class="btn btn-danger w-100 rounded-pill">Ajouter au panier</a>               
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Les dernières pépites</h2>
    <div id="latestAnnoncesCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php 
            $first = true;
            while ($row = mysqli_fetch_assoc($resultDernieres)) : 
            ?>
            <div class="carousel-item <?= $first ? 'active' : '' ?>">
                <?php $first = false; ?>
                <div class="row g-0 bg-white align-items-center">
                    <div class="col-md-5 text-center p-4">
                        <img src="<?= $row['img']; ?>" class="img-fluid annonce-carousel-img" alt="<?= htmlspecialchars($row['title']); ?>">
                    </div>
                    <div class="col-md-7 p-5">
                        <h3 class="fw-bold mb-3"><?= htmlspecialchars($row['title']); ?></h3>
                        <p class="text-danger fs-2 fw-bold mb-4"><?= number_format($row['price'], 0, ',', ' '); ?>€</p>
                        <div class="d-flex gap-3">
                            <a href="annonce_detail.php?id=<?= $row['id_a']; ?>" class="btn btn-danger btn-lg px-5 rounded-pill">Voir l'offre</a>
                            <a href="ajouter_panier.php?id_a=<?= $row['id_a']; ?>" class="btn btn-outline-dark btn-lg px-4 rounded-pill"><i class="bi bi-bag"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#latestAnnoncesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#latestAnnoncesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
        </button>
    </div>
</section>

<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container text-center">
        <p>© 2026 Copyright : <strong>LEBONCOIN - GRP 4 ECE</strong></p>
        <div class="fs-3">
            <i class="bi bi-facebook mx-2"></i>
            <i class="bi bi-instagram mx-2"></i>
            <i class="bi bi-twitter-x mx-2"></i>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>