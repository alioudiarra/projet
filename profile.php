<?php

require_once 'config.php';


require_once 'database.php';

// Vérifier si l'utilisateur est connecté sinon il le renvoie vers la page de connexion
if (!isset($_SESSION['id_u'])) {
    header("Location: connexion.php");
    exit();
} 

$id_u = (int) $_SESSION['id_u'];

// Récup utilisateur
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

// Récup annonces
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

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand brand-logo" href="acceil.php"><span>lebon</span>coin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-3 me-auto gap-lg-3">
                <li class="nav-item"><a class="nav-link active" href="acceil.php">Accueil</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Vente</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="smartphone.php">📱 Smartphones et Montre ⌚️</a></li>
                        <li><a class="dropdown-item" href="informatique.php">💻 Informatique</a></li>
                        <li><a class="dropdown-item" href="console.php">🎮 Gaming</a></li>
                        <li><a class="dropdown-item" href="casque.php">🎧 Audio & Casques</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="a-propos-de-nous.php">À propos de nous</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['id_u'])) : ?>
                    <a class="icon-btn d-flex align-items-center gap-2" href="profile.php">
                        <i class="bi bi-person-fill text-danger"></i>
                        <span class="fw-semibold small"><?= htmlspecialchars($user['pseudo'] ?? '') ?></span>
                    </a>
                    <a class="icon-btn" href="deconnexion.php"><i class="bi bi-box-arrow-right"></i></a>
                <?php else : ?>
                    <a class="icon-btn" href="inscription.php"><i class="bi bi-person"></i></a>
                <?php endif; ?>
                <a class="icon-btn" href="#"><i class="bi bi-search"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="py-5" style="background-color: #f7f7f7; min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-danger fw-bold text-uppercase mb-2">Mon espace</p>
            <h1 class="fw-bold display-5 mb-2">Mon profil</h1>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center">
                    <img src="<?= !empty($user['photo_profil']) ? htmlspecialchars($user['photo_profil']) : 'avatar.jpg' ?>" 
                         class="rounded-circle mx-auto mb-3" width="110" height="110" style="object-fit: cover; border: 4px solid #f1f1f1;">
                    <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['nom'] ?? '') ?></h3>
                    <p class="text-muted mb-4">@<?= htmlspecialchars($user['pseudo'] ?? '') ?></p>
                    <a href="update-profile.php" class="btn btn-danger w-100 rounded-3 fw-semibold">Modifier profil</a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h2 class="fw-bold mb-4">Informations personnelles</h2>
                    <p class="mb-1 text-muted small">Email</p>
                    <p class="fw-semibold border-bottom pb-2"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    <p class="mb-1 text-muted small">Ville</p>
                    <p class="fw-semibold"><?= !empty($user['ville']) ? htmlspecialchars($user['ville']) : 'Non renseignée' ?></p>
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
                                            <img src="<?= htmlspecialchars($annonce['img']) ?>" class="img-fluid" style="max-height: 300px;">
                                        </div>
                                        <div class="col-md-6 p-4">
                                            <h3 class="fw-bold"><?= htmlspecialchars($annonce['title']) ?></h3>
                                            <p class="fw-bold text-danger fs-2"><?= number_format((float)$annonce['price'], 2, ',', ' ') ?> €</p>
                                            
                                            <div class="d-flex gap-2">
                                                <a href="article.php?id=<?= $annonce['id_a'] ?>" class="btn btn-dark px-4 py-2 rounded-3">Voir</a>
                                                
                                                <a href="supprimer_annnonce.php?id=<?= $annonce['id_a'] ?>" 
                                                   class="btn btn-danger px-4 py-2 rounded-3" 
                                                   onclick="return confirm('Es-tu sûr de vouloir supprimer cette annonce ?');">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduits" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProduits" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    </button>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">Aucune annonce publiée.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 