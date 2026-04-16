<?php
session_start(); 

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
if (file_exists('config.php')) {
    require_once 'config.php';
}

// Fonction de vérification admin (simple sécurité pour l'affichage)
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos de nous - ElectroMarket GRP 4</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #f4f4f4;
        }
        .about-section {
            padding: 40px;
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .brand-logo {
            font-weight: bold;
            font-size: 1.5rem;
            text-decoration: none;
            color: #333;
        }
        .brand-logo span {
            color: #ff3e3e; /* Couleur Leboncoin */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light py-3 sticky-top shadow-sm bg-white">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="acceil.php">
            <span class="text-danger">Electro</span>Market
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

<header class="bg-dark text-white text-center py-5">
    <h1 class="display-4">À propos de nous</h1>
    <p class="lead">Découvrez l'équipe derrière ElectroMarket GRP 4</p>
</header>

<main class="container">
    <section class="about-section">
        <h2>Qui sommes-nous ?</h2>
        <p>Nous sommes une équipe passionnée par le développement web et le monde du numérique en vue de proposer des solutions adaptées à vos besoins.</p>
    </section>

    <section class="about-section">
        <h2>Notre mission</h2>
        <p>Notre mission est d’aider les clients à acheter des articles de qualité sans avoir à se déplacer, en toute sécurité.</p>
    </section>

    <section class="about-section text-center">
        <h2>Notre équipe</h2>
        <p>Composée de développeurs, designers et experts en data, nous travaillons chaque jour pour améliorer votre expérience.</p>
        <div class="row mt-4">
            <div class="col-4"><strong>Développeurs</strong></div>
            <div class="col-4"><strong>Designers</strong></div>
            <div class="col-4"><strong>Experts Data</strong></div>
        </div>
    </section>
</main>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; 2026 ElectroMarket GRP 4 - Tous droits réservés.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#" class="text-white-50 text-decoration-none">Mentions légales</a>
            <a href="#" class="text-white-50 text-decoration-none">SAV</a>
            <a href="contact.php" class="text-white-50 text-decoration-none">Contact</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>