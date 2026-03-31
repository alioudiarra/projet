<?php
session_start();
require_once 'database.php';

/*
|--------------------------------------------------------------------------
| Vérifier si l'utilisateur est connecté
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
}

$id_u = (int) $_SESSION['id_u'];

/*
|--------------------------------------------------------------------------
| Récup utilisateur
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Récup annonces
|--------------------------------------------------------------------------
*/
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
        <div class="container">

            <a class="navbar-brand brand-logo" href="#">
                <span>FOM</span>loic
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-3 me-auto gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a class="icon-btn" href="profile.php"><i class="bi bi-person"></i></a>
                    <a class="icon-btn" href="#"><i class="bi bi-search"></i></a>
                    <a class="icon-btn" href="#"><i class="bi bi-bag"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- PAGE PROFIL -->
    <section class="py-5" style="background-color: #f7f7f7; min-height: 100vh;">
        <div class="container">

            <div class="text-center mb-5">
                <p class="text-danger fw-bold text-uppercase mb-2">Mon espace</p>
                <h1 class="fw-bold display-5 mb-2">Mon profil</h1>
                <p class="text-muted">Retrouvez vos informations personnelles et vos produits publiés.</p>
            </div>

            <div class="row g-4">

                <!-- CARTE PROFIL -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body text-center p-4">

                            <img
                                src="<?= !empty($user['photo_profil']) ? htmlspecialchars($user['photo_profil']) : 'avatar.jpg' ?>"
                                alt="Photo de profil"
                                class="rounded-circle mx-auto mb-3"
                                width="110"
                                height="110"
                                style="object-fit: cover; border: 4px solid #f1f1f1;">

                            <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['nom'] ?? '') ?></h3>
                            <!-- Pseudo dynamique depuis l'inscription -->
                            <p class="text-muted mb-4">@<?= htmlspecialchars($user['pseudo'] ?? '') ?></p>

                            <a href="update-profile.php" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold mb-4">
                                Modifier profil
                            </a>

                            <div class="text-start">
                                <div class="border-top pt-3">
                                    <p class="mb-2 text-muted small">Email</p>
                                    <p class="fw-semibold mb-3"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                                </div>

                                <div class="border-top pt-3">
                                    <p class="mb-2 text-muted small">Téléphone</p>
                                    <p class="fw-semibold mb-3">
                                        <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Non renseigné' ?>
                                    </p>
                                </div>

                                <div class="border-top pt-3">
                                    <p class="mb-2 text-muted small">Ville</p>
                                    <p class="fw-semibold mb-3">
                                        <?= !empty($user['ville']) ? htmlspecialchars($user['ville']) : 'Non renseignée' ?>
                                    </p>
                                </div>

                                <div class="border-top pt-3">
                                    <p class="mb-2 text-muted small">Membre depuis</p>
                                    <p class="fw-semibold mb-0">
                                        <?= !empty($user['created_at']) ? date('Y', strtotime($user['created_at'])) : 'Non renseigné' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INFOS -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4">Informations personnelles</h2>

                            <div class="border-bottom pb-3 mb-3">
                                <p class="text-muted mb-1">Pseudo</p>
                                <p class="fw-semibold mb-0">@<?= htmlspecialchars($user['pseudo'] ?? '') ?></p>
                            </div>

                            <div class="border-bottom pb-3 mb-3">
                                <p class="text-muted mb-1">Nom complet</p>
                                <p class="fw-semibold mb-0"><?= htmlspecialchars($user['nom'] ?? '') ?></p>
                            </div>

                            <div class="border-bottom pb-3 mb-3">
                                <p class="text-muted mb-1">Email</p>
                                <p class="fw-semibold mb-0"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                            </div>

                            <div class="border-bottom pb-3 mb-3">
                                <p class="text-muted mb-1">Téléphone</p>
                                <p class="fw-semibold mb-0">
                                    <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Non renseigné' ?>
                                </p>
                            </div>

                            <div class="border-bottom pb-3 mb-3">
                                <p class="text-muted mb-1">Ville</p>
                                <p class="fw-semibold mb-0">
                                    <?= !empty($user['ville']) ? htmlspecialchars($user['ville']) : 'Non renseignée' ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-muted mb-1">Bio</p>
                                <p class="fw-semibold mb-0">
                                    <?= !empty($user['bio']) ? nl2br(htmlspecialchars($user['bio'])) : 'Aucune bio pour le moment.' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MES ANNONCES -->
            <div class="mt-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Mes annonces</h2>
                </div>

                <?php if (!empty($annonces)) : ?>
                    <div id="carouselProduits" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-indicators">
                            <?php foreach ($annonces as $index => $annonce) : ?>
                                <button 
                                    type="button"
                                    data-bs-target="#carouselProduits"
                                    data-bs-slide-to="<?= $index ?>"
                                    class="<?= $index === 0 ? 'active' : '' ?>"
                                    <?= $index === 0 ? 'aria-current="true"' : '' ?>>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="carousel-inner">
                            <?php foreach ($annonces as $index => $annonce) : ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div class="row g-0 align-items-center">

                                            <div class="col-md-6 text-center p-4" style="background-color: #eef3f7;">
                                                <img 
                                                    src="<?= !empty($annonce['img']) ? htmlspecialchars($annonce['img']) : 'avatar.jpg' ?>" 
                                                    alt="<?= htmlspecialchars($annonce['title']) ?>"
                                                    class="img-fluid"
                                                    style="max-height: 320px; object-fit: contain;"
                                                >
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card-body p-4 p-md-5">

                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 mb-3">
                                                        <?= !empty($annonce['type']) ? htmlspecialchars($annonce['type']) : 'Annonce' ?>
                                                    </span>

                                                    <h3 class="fw-bold mb-3">
                                                        <?= htmlspecialchars($annonce['title']) ?>
                                                    </h3>

                                                    <p class="text-muted mb-3">
                                                        <?= !empty($annonce['desc']) ? nl2br(htmlspecialchars($annonce['desc'])) : 'Aucune description.' ?>
                                                    </p>

                                                    <p class="fw-bold text-danger fs-2 mb-2">
                                                        <?= number_format((float)$annonce['price'], 2, ',', ' ') ?> €
                                                    </p>

                                                    <?php
                                                    $statutTexte = 'Inconnu';
                                                    if ($annonce['status'] == 1) {
                                                        $statutTexte = 'Disponible';
                                                    } elseif ($annonce['status'] == 2) {
                                                        $statutTexte = 'Vendu';
                                                    } elseif ($annonce['status'] == 3) {
                                                        $statutTexte = 'Réservé';
                                                    }
                                                    ?>

                                                    <p class="mb-4">
                                                        <span class="badge bg-dark">
                                                            Statut : <?= $statutTexte ?>
                                                        </span>
                                                    </p>

                                                    <a href="#" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold">
                                                        Voir l'annonce
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($annonces) > 1) : ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduits" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduits" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-5 text-center">
                            <h3 class="fw-bold mb-3">Aucune annonce</h3>
                            <p class="text-muted mb-0">
                                Tu n'as pas encore ajouté d'annonce.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="mt-5 text-white" style="background: linear-gradient(90deg, #1b2028, #1f2630);">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-3">
                    <h3 class="fw-bold mb-3"><span class="text-danger">PH</span>LOX</h3>
                    <p class="mb-0">Votre boutique en ligne pour les derniers produits tech : smartphones, accessoires, gaming et plus encore.</p>
                </div>
                <div class="col-md-3">
                    <h4 class="fw-bold mb-3">PRODUITS</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">Smartphones</li>
                        <li class="mb-2">Casques</li>
                        <li class="mb-2">Gaming</li>
                        <li class="mb-2">Accessoires</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="fw-bold mb-3">LIENS UTILES</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">Votre compte</li>
                        <li class="mb-2">Commandes</li>
                        <li class="mb-2">Aide</li>
                        <li class="mb-2">Contact</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="fw-bold mb-3">CONTACT</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">Paris, France</li>
                        <li class="mb-2">contact@phlox.com</li>
                        <li class="mb-2">+33 6 00 00 00 00</li>
                    </ul>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 border-secondary">
                <p class="mb-0">© 2026 Copyright : PHLOX</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>