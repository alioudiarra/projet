
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
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

<div class="form-wrapper">
    <div class="form-card">

      <!-- En-tête -->
      <div class="form-header">
        <div class="badge-tag"><i class="bi bi-megaphone me-1"></i> Réclamation</div>
        <h1>Nous contacter</h1>
        <p>Un problème avec une annonce ? Remplissez ce formulaire, nous vous répondons rapidement.</p>
      </div>

      <!-- Corps -->
      <div class="form-body">

        <!-- Message de succès -->
        <div class="alert-success-custom" id="successMsg">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <span>Votre réclamation a bien été envoyée. Nous vous répondrons sous 48h.</span>
        </div>

        <!-- Message d'erreur -->
        <div class="alert-error-custom" id="errorMsg">
          <i class="bi bi-x-circle-fill fs-5"></i>
          <span>Une erreur est survenue. Veuillez réessayer.</span>
        </div>

        <form action="envoyer.php" method="POST" id="reclamationForm" novalidate>

          <!-- Nom / Prénom -->
          <div class="mb-3">
            <label for="nom" class="form-label">Nom & Prénom *</label>
            <div class="input-icon-wrap">
              <i class="bi bi-person"></i>
              <input type="text" class="form-control" id="nom" name="nom"
                     placeholder="Jean Dupont" required>
            </div>
            <div class="invalid-feedback">Veuillez entrer votre nom.</div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Adresse Email *</label>
            <div class="input-icon-wrap">
              <i class="bi bi-envelope"></i>
              <input type="email" class="form-control" id="email" name="email"
                     placeholder="votre@email.com" required>
            </div>
            <div class="invalid-feedback">Veuillez entrer un email valide.</div>
          </div>

          <!-- Numéro d'annonce -->
          <div class="mb-3">
            <label for="numero_annonce" class="form-label">Numéro d'annonce / commande *</label>
            <div class="input-icon-wrap">
              <i class="bi bi-hash"></i>
              <input type="text" class="form-control" id="numero_annonce" name="numero_annonce"
                     placeholder="ex: ANN-20456" required>
            </div>
            <div class="invalid-feedback">Veuillez entrer un numéro d'annonce.</div>
          </div>

          <div class="divider"></div>

          <!-- Sujet -->
          <div class="mb-3">
            <label for="sujet" class="form-label">Sujet de la réclamation *</label>
            <select class="form-select" id="sujet" name="sujet" required>
              <option value="" disabled selected>-- Choisissez un sujet --</option>
              <option value="Annonce frauduleuse">Annonce frauduleuse</option>
              <option value="Problème de paiement">Problème de paiement</option>
              <option value="Article non reçu">Article non reçu</option>
              <option value="Article non conforme">Article non conforme à l'annonce</option>
              <option value="Vendeur non réactif">Vendeur non réactif</option>
              <option value="Autre">Autre</option>
            </select>
            <div class="invalid-feedback">Veuillez choisir un sujet.</div>
          </div>

          <!-- Message -->
          <div class="mb-4">
            <label for="message" class="form-label">Description du problème *</label>
            <textarea class="form-control" id="message" name="message"
                      placeholder="Décrivez votre problème en détail..." required></textarea>
            <div class="invalid-feedback">Veuillez décrire votre problème.</div>
          </div>

          <!-- Bouton -->
          <button type="submit" class="btn btn-submit">
            <i class="bi bi-send-fill"></i> Envoyer la réclamation
          </button>

        </form>

        <p class="privacy-note">
          <i class="bi bi-shield-lock-fill"></i>
          Vos données sont confidentielles et utilisées uniquement pour traiter votre réclamation.
        </p>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ── Affichage du message succès/erreur selon l'URL ──
    const params = new URLSearchParams(window.location.search);
    const statut = params.get('statut');

    if (statut === 'succes') {
      const msg = document.getElementById('successMsg');
      msg.style.display = 'flex';
      // Faire défiler vers le haut pour voir le message
      msg.scrollIntoView({ behavior: 'smooth' });
    }

    if (statut === 'erreur') {
      const msg = document.getElementById('errorMsg');
      msg.style.display = 'flex';
    }

    // ── Validation Bootstrap côté client ──
    const form = document.getElementById('reclamationForm');

    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  </script>

</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>