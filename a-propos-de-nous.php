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
    <title>À propos de nous - LEBONCOIN GRP 4</title>

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
                    <a class="nav-link" href="a-propos-de-nous.php">
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

                <!-- 🛒 Panier -->
                <a class="icon-btn" href="panier.php">
                    <i class="bi bi-bag"></i>
                </a>

                <!-- ❤️ Favoris (UN SEUL maintenant) -->
                <a class="nav-link p-0 fw-bold text-danger" href="favoris.php">
                    Mes favoris
                </a>

            </div>

        </div>
    </div>
</nav>

<header class="bg-dark text-white text-center py-5">
    <h1 class="display-4">À propos de nous</h1>
    <p class="lead">Découvrez l'équipe derrière LEBONCOIN GRP 4</p>
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
        <p>&copy; 2026 LEBONCOIN GRP 4 - Tous droits réservés.</p>
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