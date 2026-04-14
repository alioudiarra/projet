<?php
            
require_once 'database.php';
require_once 'config.php';

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

$message = "";
$message_type = "";

$defaultUser = [
    'nom' => '',
    'email' => '',
    'phone' => '',
    'bio' => '',
    'photo_profil' => ''
];

$uploadProfilDir = "uploads/profils/";
$uploadAnnonceDir = "uploads/annonces/";

if (!is_dir($uploadProfilDir)) {
    mkdir($uploadProfilDir, 0777, true);
}

if (!is_dir($uploadAnnonceDir)) {
    mkdir($uploadAnnonceDir, 0777, true);
}

/* =========================
   SUPPRIMER UNE ANNONCE
========================= */
if (isset($_POST['delete_annonce'])) {
    $id_a_to_delete = (int)$_POST['id_a'];
    
    // Sécurité : on vérifie l'id_u pour que personne ne supprime l'annonce d'un autre
    $sqlDelete = "DELETE FROM annnonce WHERE id_a = ? AND id_u = ?";
    $stmtDelete = mysqli_prepare($conn, $sqlDelete);
    
    if ($stmtDelete) {
        mysqli_stmt_bind_param($stmtDelete, "ii", $id_a_to_delete, $id_u);
        if (mysqli_stmt_execute($stmtDelete)) {
            $message = "Annonce supprimée avec succès.";
            $message_type = "success";
        } else {
            $message = "Erreur lors de la suppression.";
            $message_type = "danger";
        }
    }
}

/* =========================
   RÉCUP USER
========================= */
$sqlUser = "SELECT * FROM users WHERE id_u = ?";
$stmtUser = mysqli_prepare($conn, $sqlUser);

if ($stmtUser) {
    mysqli_stmt_bind_param($stmtUser, "i", $id_u);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);
    $user = mysqli_fetch_assoc($resultUser);

    if (!$user) {
        $user = $defaultUser;
    }
} else {
    $user = $defaultUser;
    $message = "Erreur lors du chargement du profil.";
    $message_type = "danger";
}

/* =========================
   UPDATE PROFIL
========================= */
if (isset($_POST['update_profile'])) {
    $bio = trim($_POST['bio'] ?? '');
    $photo_profil = $user['photo_profil'] ?? '';

    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === 0) {
        $tmpName = $_FILES['photo_profil']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['photo_profil']['name']);
        $targetFile = $uploadProfilDir . $fileName;

        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowedTypes)) {
            if (move_uploaded_file($tmpName, $targetFile)) {
                $photo_profil = $targetFile;
            }
        }
    }

    $sqlUpdate = "UPDATE users SET bio = ?, photo_profil = ? WHERE id_u = ?";
    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

    if ($stmtUpdate) {
        mysqli_stmt_bind_param($stmtUpdate, "ssi", $bio, $photo_profil, $id_u);

        if (mysqli_stmt_execute($stmtUpdate)) {
            $message = "Profil mis à jour avec succès.";
            $message_type = "success";
        } else {
            $message = "Erreur lors de la mise à jour du profil.";
            $message_type = "danger";
        }
    }
}

/* =========================
   AJOUTER UNE ANNONCE
========================= */
if (isset($_POST['add_annonce'])) {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $status = (int)($_POST['status'] ?? 1); // Forcé en INT
    $type = trim($_POST['type'] ?? '');
    $img = '';

    if (!empty($title) && !empty($desc) && $price !== '') {

        if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
            $tmpName = $_FILES['img']['tmp_name'];
            $fileName = time() . "_" . basename($_FILES['img']['name']);
            $targetFile = $uploadAnnonceDir . $fileName;

            $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $img = $targetFile;
                }
            }
        }

        $sqlInsertAnnonce = "INSERT INTO annnonce (title, `desc`, price, status, type, img, id_u) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertAnnonce = mysqli_prepare($conn, $sqlInsertAnnonce);

        if ($stmtInsertAnnonce) {
            mysqli_stmt_bind_param($stmtInsertAnnonce, "ssdsssi", $title, $desc, $price, $status, $type, $img, $id_u);

            if (mysqli_stmt_execute($stmtInsertAnnonce)) {
                $redirections = [
                    'console'    => 'console.php',
                    'manette'    => 'console.php',
                    'jeux video' => 'console.php',
                    'ecouteur'   => 'casque.php',
                    'casque'     => 'casque.php',
                    'enceinte'   => 'casque.php',
                    'smartphone' => 'smartphone.php'
                ];
                $page = $redirections[strtolower($type)] ?? 'acceil.php';
                header("Location: " . $page . "?success=1");
                exit();
            }
        }
    }
}

/* =========================
   MODIFIER UNE ANNONCE (Correctif Erreur SQL ligne 224)
========================= */
if (isset($_POST['update_annonce'])) {
    $id_a = (int)($_POST['id_a'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    $price = trim($_POST['price'] ?? '');
    
    // CORRECTIF : On s'assure que status est bien un entier et jamais vide
    $status = !empty($_POST['status']) ? (int)$_POST['status'] : 1;
    
    $type = trim($_POST['type'] ?? '');
    $img = $_POST['ancienne_img'] ?? '';

    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $tmpName = $_FILES['img']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['img']['name']);
        $targetFile = $uploadAnnonceDir . $fileName;
        if (move_uploaded_file($tmpName, $targetFile)) {
            $img = $targetFile;
        }
    }

    $sqlUpdateAnnonce = "UPDATE annnonce 
                         SET title = ?, `desc` = ?, price = ?, status = ?, type = ?, img = ?
                         WHERE id_a = ? AND id_u = ?";
    $stmtUpdateAnnonce = mysqli_prepare($conn, $sqlUpdateAnnonce);

    if ($stmtUpdateAnnonce) {
        mysqli_stmt_bind_param($stmtUpdateAnnonce, "ssdsssii", $title, $desc, $price, $status, $type, $img, $id_a, $id_u);

        if (mysqli_stmt_execute($stmtUpdateAnnonce)) {
            $message = "Annonce modifiée avec succès.";
            $message_type = "success";
        } else {
            $message = "Erreur modification : " . mysqli_stmt_error($stmtUpdateAnnonce);
            $message_type = "danger";
        }
    }
}

/* =========================
   RÉCUP ANNONCES
========================= */
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
    <title>Mon Espace - LEBONCOIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f7f7f7; }
        .profile-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .profile-image { width: 130px; height: 130px; object-fit: cover; border-radius: 50%; border: 4px solid #f1f1f1; }
        .annonce-image { width: 100%; max-height: 200px; object-fit: contain; border-radius: 12px; background: #fff; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Mon espace personnel</h1>
        <a href="acceil.php" class="btn btn-link text-danger text-decoration-none"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a>
    </div>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-<?= $message_type ?> alert-dismissible fade show text-center">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card profile-card mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Mon Profil</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-3">
                            <img src="<?= !empty($user['photo_profil']) ? htmlspecialchars($user['photo_profil']) : 'avatar.jpg' ?>" class="profile-image mb-2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Changer la photo</label>
                            <input type="file" name="photo_profil" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ma Bio</label>
                            <textarea name="bio" rows="3" class="form-control"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-danger w-100">Mettre à jour mon profil</button>
                    </form>
                </div>
            </div>

            <div class="card profile-card">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Vendre un article</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3"><label class="form-label">Titre</label><input type="text" name="title" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Description</label><textarea name="desc" class="form-control" rows="3" required></textarea></div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="type" class="form-select" required>
                                    <option value="smartphone">Smartphone / Montre</option>
                                    <option value="console">Console / Manette</option>
                                    <option value="jeux video">Jeux Vidéo</option>
                                    <option value="casque">Audio / Casque</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image du produit</label>
                            <input type="file" name="img" class="form-control" required>
                        </div>
                        <input type="hidden" name="status" value="1">
                        <button type="submit" name="add_annonce" class="btn btn-dark w-100">Publier l'annonce</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <h3 class="fw-bold mb-4">Gérer mes annonces (<?= count($annonces) ?>)</h3>
            <?php foreach ($annonces as $annonce) : ?>
                <div class="card profile-card mb-3">
                    <div class="card-body">
                        <?php if (!empty($annonce['img'])) : ?>
                            <img src="<?= htmlspecialchars($annonce['img']) ?>" class="annonce-image mb-3">
                        <?php endif; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_a" value="<?= (int)$annonce['id_a'] ?>">
                            <input type="hidden" name="ancienne_img" value="<?= htmlspecialchars($annonce['img'] ?? '') ?>">

                            <div class="mb-2">
                                <input type="text" name="title" class="form-control fw-bold" value="<?= htmlspecialchars($annonce['title']) ?>">
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="1" <?= $annonce['status'] == 1 ? 'selected' : '' ?>>Disponible</option>
                                        <option value="2" <?= $annonce['status'] == 2 ? 'selected' : '' ?>>Vendu</option>
                                        <option value="3" <?= $annonce['status'] == 3 ? 'selected' : '' ?>>Réservé</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="number" step="0.01" name="price" class="form-control form-control-sm" value="<?= $annonce['price'] ?>">
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" name="update_annonce" class="btn btn-dark btn-sm flex-grow-1">Enregistrer</button>
                                <button type="submit" name="delete_annonce" class="btn btn-outline-danger btn-sm" onclick="return confirm('Supprimer définitivement ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>