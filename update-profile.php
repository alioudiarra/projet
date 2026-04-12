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
    $status = trim($_POST['status'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $img = '';

    if (!empty($title) && !empty($desc) && $price !== '' && !empty($status) && !empty($type)) {

        if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
            $tmpName = $_FILES['img']['tmp_name'];
            $fileName = time() . "_" . basename($_FILES['img']['name']);
            $targetFile = $uploadAnnonceDir . $fileName;

            $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowedTypes)) {
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
                $message = "Annonce ajoutée avec succès.";
                $message_type = "success";
            } else {
                $message = "Erreur lors de l'ajout de l'annonce : " . mysqli_stmt_error($stmtInsertAnnonce);
                $message_type = "danger";
            }
        } else {
            $message = "Erreur préparation INSERT annonce : " . mysqli_error($conn);
            $message_type = "danger";
        }
    } else {
        $message = "Remplis tous les champs de l'annonce.";
        $message_type = "danger";
    }
}

/* =========================
   MODIFIER UNE ANNONCE
========================= */
if (isset($_POST['update_annonce'])) {
    $id_a = (int)($_POST['id_a'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $img = $_POST['ancienne_img'] ?? '';

    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $tmpName = $_FILES['img']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['img']['name']);
        $targetFile = $uploadAnnonceDir . $fileName;

        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowedTypes)) {
            if (move_uploaded_file($tmpName, $targetFile)) {
                $img = $targetFile;
            }
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
            $message = "Erreur lors de la modification de l'annonce : " . mysqli_stmt_error($stmtUpdateAnnonce);
            $message_type = "danger";
        }
    } else {
        $message = "Erreur préparation UPDATE annonce : " . mysqli_error($conn);
        $message_type = "danger";
    }
}

/* =========================
   RELOAD USER
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
    <title>Modifier mon profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f7f7f7; }
        .profile-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .profile-image {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f1f1f1;
        }
        .annonce-image {
            width: 100%;
            max-height: 220px;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <p class="text-danger fw-bold text-uppercase mb-2">Mon espace</p>
        <h1 class="fw-bold display-5 mb-2">Modifier mon profil</h1>
        <p class="text-muted">Mettez à jour votre photo, votre bio et vos annonces.</p>
    </div>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-<?= htmlspecialchars($message_type) ?> text-center">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card profile-card mb-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <?php if (!empty($user['photo_profil'])) : ?>
                            <img src="<?= htmlspecialchars($user['photo_profil']) ?>" alt="Photo de profil" class="profile-image mb-3">
                        <?php else : ?>
                            <img src="avatar.jpg" alt="Photo par défaut" class="profile-image mb-3">
                        <?php endif; ?>

                        <h3 class="fw-bold mb-1"><?= htmlspecialchars($user['nom'] ?? '') ?></h3>
                        <p class="text-muted mb-0"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="photo_profil" class="form-label fw-bold">Photo de profil</label>
                            <input type="file" name="photo_profil" id="photo_profil" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label fw-bold">Bio</label>
                            <textarea name="bio" id="bio" rows="5" class="form-control"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-danger">
                            Enregistrer le profil
                        </button>
                    </form>
                </div>
            </div>

            <div class="card profile-card">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h4 fw-bold mb-4">Ajouter une annonce</h2>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="desc" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" step="0.01" name="price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-control" required>
                                <option value="">Choisir un statut</option>
                                <option value="1">Disponible</option>
                                <option value="2">Vendu</option>
                                <option value="3">Réservé</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" placeholder="ex: électronique">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image annonce</label>
                            <input type="file" name="img" class="form-control">
                        </div>

                        <button type="submit" name="add_annonce" class="btn btn-dark">
                            Ajouter l'annonce
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card profile-card">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-4">Mes annonces</h2>

                    <?php if (!empty($annonces)) : ?>
                        <?php foreach ($annonces as $annonce) : ?>
                            <div class="border rounded-4 p-3 mb-4 bg-light">
                                <?php if (!empty($annonce['img'])) : ?>
                                    <img src="<?= htmlspecialchars($annonce['img']) ?>" class="annonce-image mb-3" alt="Image annonce">
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_a" value="<?= (int)$annonce['id_a'] ?>">
                                    <input type="hidden" name="ancienne_img" value="<?= htmlspecialchars($annonce['img'] ?? '') ?>">

                                    <div class="mb-2">
                                        <label class="form-label">Titre</label>
                                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($annonce['title']) ?>">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea name="desc" class="form-control" rows="3"><?= htmlspecialchars($annonce['desc']) ?></textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Prix</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($annonce['price']) ?>">
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Statut</label>
                                        <select name="status" class="form-control">
                                            <option value="1" <?= $annonce['status'] == 1 ? 'selected' : '' ?>>Disponible</option>
                                            <option value="2" <?= $annonce['status'] == 2 ? 'selected' : '' ?>>Vendu</option>
                                            <option value="3" <?= $annonce['status'] == 3 ? 'selected' : '' ?>>Réservé</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Type</label>
                                        <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($annonce['type']) ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nouvelle image</label>
                                        <input type="file" name="img" class="form-control">
                                    </div>

                                    <button type="submit" name="update_annonce" class="btn btn-outline-dark w-100">
                                        Modifier cette annonce
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-muted mb-0">Aucune annonce pour le moment.</p>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="profile.php" class="btn btn-outline-danger">
                            Retour au profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>