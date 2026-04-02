<?php session_start(); ?>

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
  <nav>

  </nav>
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
            <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <div class="d-flex align-items-center gap-3">

        <?php if (isset($_SESSION['id_u'])) : ?>
    <a class="icon-btn d-flex align-items-center gap-2" href="profile.php">
        <i class="bi bi-person-fill text-danger"></i>
        <span class="fw-semibold small"><?= htmlspecialchars($_SESSION['pseudo'] ?? '') ?></span>
    </a>
    <a class="icon-btn" href="deconnexion.php"><i class="bi bi-box-arrow-right"></i></a>
<?php else : ?>
    <a class="icon-btn" href="inscription.php"><i class="bi bi-person"></i></a>
<?php endif; ?>

<a class="icon-btn" href="#"><i class="bi bi-search"></i></a>
<a class="icon-btn" href="#"><i class="bi bi-bag"></i></a>
</div>

    </div>
</div>
</nav>



<!-- HERO CAROUSEL -->

<div id="heroCarousel" class="carousel slide container mt-5" data-bs-ride="carousel">

<div class="carousel-indicators">
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
<button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="5"></button>
</div>

<div class="carousel-inner">


<!-- Slide 1 -->
<div class="carousel-item active">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/d4bbced5-3174-492f-b45d-f3fb22565a02-1_c7854bef-96b0-48f2-acd4-72d8ee183e25.avif" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Un design élégant. Une technologie puissante.</h1>
<p class="lead">Découvrez le smartphone nouvelle génération.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>


<!-- Slide 2 -->
<div class="carousel-item">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/AirPods-Max-5-600x600.png" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Un son immersif.</h1>
<p class="lead">Découvrez nos écouteurs nouvelle génération.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>


<!-- Slide 3 -->
<div class="carousel-item">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/pngegg.png" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Une montre connectée intelligente.</h1>
<p class="lead">Suivez votre santé et vos activités.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>


<!-- Slide 4 -->
<div class="carousel-item">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/pngegg (2).png" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Performance et puissance.</h1>
<p class="lead">Découvrez nos laptops nouvelle génération.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>


<!-- Slide 5 -->
<div class="carousel-item">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/ps5-console-png-ywbv2gv3gfw23o3w.png" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Jouez sans limites.</h1>
<p class="lead">La console nouvelle génération.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>


<!-- Slide 6 -->
<div class="carousel-item">
<div class="card border-0 shadow-lg p-4">
<div class="row flex-lg-row-reverse align-items-center g-5">

<div class="col-lg-6">
<img src="IMG/pngegg (4).png" class="img-fluid">
</div>

<div class="col-lg-6">
<h1 class="display-5 fw-bold mb-3">Un son puissant.</h1>
<p class="lead">Une enceinte connectée intelligente.</p>

<div class="d-flex gap-3">
<button class="btn btn-danger btn-lg">Achetez maintenant</button>
<button class="btn btn-outline-secondary btn-lg">En savoir plus</button>
</div>

</div>

</div>
</div>
</div>

</div>


<button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>



<!-- SECTION CATEGORIES -->

<div class="container my-5">
<div class="row g-4" id="categories">

<div class="col-lg-4 col-md-6">
<div class="promo-card promo-dark">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Ecouteur</h3>
<div class="promo-bgword">Ecouteur</div>
<a class="btn btn-danger btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/AirPods-Max-5-600x600.png">
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="promo-card promo-yellow">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Montre</h3>
<div class="promo-bgword">Montre</div>
<a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/pngegg.png">
</div>
</div>

<div class="col-lg-4">
<div class="promo-card promo-red">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Ordinateur portable</h3>
<div class="promo-bgword">PC</div>
<a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/pngegg (2).png">
</div>
</div>

<div class="col-lg-4">
<div class="promo-card promo-light">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Console  </h3>
<div class="promo-bgword">CONSOLE</div>
<a class="btn btn-danger btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/ps5-console-png-ywbv2gv3gfw23o3w.png">
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="promo-card promo-green">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Jeux</h3>
<div class="promo-bgword">CASQUE VR</div>
<a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/pngegg (3).png">
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="promo-card promo-blue">
<div class="promo-content">
<small>Decouvrir</small>
<h3>Enceinte</h3>
<div class="promo-bgword">ENCEINTE</div>
<a class="btn btn-light btn-sm rounded-pill px-4 mt-3">Parcourir</a>
</div>
<img class="promo-img" src="IMG/pngegg (4).png">
</div>
</div>

</div>
</div>
<section class="container my-5">

<h2 class="text-center mb-5 fw-bold">Produits populaires</h2>

<div class="row g-4">

<!-- produit 1 -->
<div class="col-lg-3 col-md-6">
<div class="card h-100 shadow-sm">

<img src="IMG/d4bbced5-3174-492f-b45d-f3fb22565a02-1_c7854bef-96b0-48f2-acd4-72d8ee183e25.avif" class="card-img-top p-3">

<div class="card-body text-center">
<h5 class="card-title">Smartphone Pro</h5>
<p class="text-danger fw-bold fs-5">899€</p>
<button class="btn btn-danger w-100">Ajouter au panier</button>
</div>

</div>
</div>


<!-- produit 2 -->
<div class="col-lg-3 col-md-6">
<div class="card h-100 shadow-sm">

<img src="IMG/AirPods-Max-5-600x600.png" class="card-img-top p-3">

<div class="card-body text-center">
<h5 class="card-title">AirPods Max</h5>
<p class="text-danger fw-bold fs-5">549€</p>
<button class="btn btn-danger w-100">Ajouter au panier</button>
</div>

</div>
</div>


<!-- produit 3 -->
<div class="col-lg-3 col-md-6">
<div class="card h-100 shadow-sm">

<img src="IMG/pngegg (2).png" class="card-img-top p-3">

<div class="card-body text-center">
<h5 class="card-title">Laptop Pro</h5>
<p class="text-danger fw-bold fs-5">1299€</p>
<button class="btn btn-danger w-100">Ajouter au panier</button>
</div>

</div>
</div>


<!-- produit 4 -->
<div class="col-lg-3 col-md-6">
<div class="card h-100 shadow-sm">

<img src="IMG/ps5-console-png-ywbv2gv3gfw23o3w.png" class="card-img-top p-3">

<div class="card-body text-center">
<h5 class="card-title">PlayStation 5</h5>
<p class="text-danger fw-bold fs-5">499€</p>
<button class="btn btn-danger w-100">Ajouter au panier</button>
</div>

</div>
</div>

</div>

</section>
<footer class="bg-dark text-light pt-5 pb-4">

<div class="container text-md-left">

<div class="row text-md-left">

<!-- Logo -->
<div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
<h5 class="text-uppercase fw-bold mb-4">
<span style="color:red;">PH</span>LOX
</h5>

<p>
Votre boutique en ligne pour les derniers produits tech :
smartphones, accessoires, gaming et plus encore.
</p>
</div>

<!-- Liens -->
<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
<h5 class="text-uppercase fw-bold mb-4">
Produits
</h5>

<p><a href="#" class="text-light text-decoration-none">Téléphones</a></p>
<p><a href="#" class="text-light text-decoration-none">Casques</a></p>
<p><a href="#" class="text-light text-decoration-none">Jeux</a></p>
<p><a href="#" class="text-light text-decoration-none">Accessoires</a></p>
</div>

<!-- Liens utiles -->
<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
<h5 class="text-uppercase fw-bold mb-4">
Liens utiles
</h5>

<p><a href="#" class="text-light text-decoration-none">Votre compte</a></p>
<p><a href="#" class="text-light text-decoration-none">Commandes</a></p>
<p><a href="#" class="text-light text-decoration-none">Aide</a></p>
<p><a href="#" class="text-light text-decoration-none">Contact</a></p>
</div>

<!-- Contact -->
<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
<h5 class="text-uppercase fw-bold mb-4">
Contact
</h5>

<p><i class="bi bi-house"></i> Paris, France</p>
<p><i class="bi bi-envelope"></i> contact@phlox.com</p>
<p><i class="bi bi-phone"></i> +33 6 00 00 00 00</p>
</div>

</div>

<hr class="mb-4">

<!-- réseaux -->
<div class="row align-items-center">

<div class="col-md-7 col-lg-8">

<p>
© 2026 Copyright :
<strong>PHLOX</strong>
</p>

</div>

<div class="col-md-5 col-lg-4 text-md-end">

<a href="#" class="text-light me-4">
<i class="bi bi-facebook"></i>
</a>

<a href="#" class="text-light me-4">
<i class="bi bi-instagram"></i>
</a>

<a href="#" class="text-light me-4">
<i class="bi bi-twitter-x"></i>
</a>

<a href="#" class="text-light">
<i class="bi bi-youtube"></i>
</a>

</div>

</div>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>