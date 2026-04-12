<?php
require_once 'config.php';
require_once 'database.php';

$recherche = $_GET['q'] ?? '';

if (empty($recherche)) {
    header("Location: acceil.php");
    exit;
}

$sql = "SELECT * FROM annnonce WHERE title LIKE ? OR `desc` LIKE ?";
$stmt = mysqli_prepare($conn, $sql);
$search = "%" . $recherche . "%";
mysqli_stmt_bind_param($stmt, "ss", $search, $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$annonces = [];
while ($row = mysqli_fetch_assoc($result)) {
    $annonces[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats pour "<?= htmlspecialchars($recherche) ?>"</title>
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
                        <li><a class="dropdown-item" href="smartphone.php">📱 Smartphones et Montre ⌚️</a></li>
                        <li><a class="dropdown-item" href="informatique.php">💻 Informatique</a></li>
                        <li><a class="dropdown-item" href="console.php">🎮 Gaming</a></li>
                        <li><a class="dropdown-item" href="casque.php">🎧 Audio & Casques</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-bold" href="#">Voir tout</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="a-propos-de-nous.html">À propos de nous</a>
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

            <!-- 🔍 Barre de recherche ajoutée ici -->
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

            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['id_u'])): ?>
                    <a class="icon-btn d-flex align-items-center gap-2 text-decoration-none text-dark" href="profile.php">
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
                    <i class="bi bi-bag"></i>
                </a>

                <a class="nav-link p-0 fw-bold text-danger" href="favoris.php">
                    Mes favoris
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- ===== RÉSULTATS ===== -->
<div class="container py-5">

    <div class="text-center mb-5">
        <p class="text-danger fw-bold text-uppercase mb-2">Recherche</p>
        <h1 class="fw-bold display-5 mb-2">Résultats pour "<?= htmlspecialchars($recherche) ?>"</h1>
        <p class="text-muted"><?= count($annonces) ?> annonce(s) trouvée(s)</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>

                <?php
                    // ✅ Redirection vers la bonne page selon le type
                    $redirections = [
                        'console'    => 'console.php',
                        'manette'    => 'console.php',
                        'jeux video' => 'console.php',
                        'ecouteur'   => 'audio.php',
                        'casque'     => 'audio.php',
                        'enceinte'   => 'audio.php',
                    ];
                    $typeLower = strtolower($annonce['type'] ?? '');
                    $pageCat = $redirections[$typeLower] ?? 'index.php';

                    $statuts  = [1 => 'Disponible', 2 => 'Vendu', 3 => 'Réservé'];
                    $couleurs = [1 => 'success', 2 => 'secondary', 3 => 'warning'];
                    $s = $annonce['status'];
                ?>

                <div class="col-sm-6 col-lg-4">
                    <!-- ✅ Clique sur la carte → annonce_detail.php avec l'id -->
                    <a href="annonce_detail.php?id=<?= (int)$annonce['id_a'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0 rounded-4">

                            <?php if (!empty($annonce['img'])): ?>
                                <img src="<?= htmlspecialchars($annonce['img']) ?>"
                                     class="card-img-top rounded-top-4"
                                     style="height: 220px; object-fit: cover;"
                                     alt="<?= htmlspecialchars($annonce['title']) ?>">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height: 220px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <!-- Badge catégorie cliquable -->
                                <a href="<?= $pageCat ?>" 
                                   class="badge bg-danger mb-2 text-decoration-none"
                                   onclick="event.stopPropagation()">
                                    <?= htmlspecialchars($annonce['type']) ?>
                                </a>
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <p class="card-text text-muted small"><?= htmlspecialchars($annonce['desc']) ?></p>
                            </div>

                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center pb-3">
                                <span class="fw-bold text-danger fs-5"><?= number_format($annonce['price'], 2) ?> €</span>
                                <span class="badge bg-<?= $couleurs[$s] ?? 'secondary' ?>">
                                    <?= $statuts[$s] ?? 'Inconnu' ?>
                                </span>
                            </div>

                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted fs-5 mt-3">Aucune annonce trouvée pour "<?= htmlspecialchars($recherche) ?>"</p>
                <a href="acceil.php" class="btn btn-danger mt-2">Retour à l'accueil</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>