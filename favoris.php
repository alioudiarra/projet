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

$stmt = mysqli_prepare($conn, $sql); // ? remplacer par l'id de maniere securise 
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
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
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