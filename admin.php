<?php
session_start();

// ============================================================
//  ROLES
// ============================================================
define('ROLE_ADMIN', 0);
define('ROLE_USER', 1);

// ============================================================
//  CONNEXION BDD
// ============================================================
$host   = "localhost";
$dbname = "projet";
$userdb = "root";
$passdb = "root";

$conn = mysqli_connect($host, $userdb, $passdb, $dbname);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// ============================================================
//  SÉCURITÉ — accolades + redirect ajoutés
// ============================================================
if (!isset($_SESSION['id_u']) || ($_SESSION['perm'] ?? null) != ROLE_ADMIN) {
    header("Location: acceil.php");
    exit;
}

$message  = '';
$type_msg = '';

// ============================================================
//  SUPPRESSION
// ============================================================
if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {

    $id = (int) $_POST['id_u'];

    if ($id === (int) $_SESSION['id_u']) {
        $message  = "Vous ne pouvez pas supprimer votre propre compte.";
        $type_msg = "erreur";
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id_u = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $message  = "Utilisateur supprimé avec succès.";
        $type_msg = "succes";
    }
}

// ============================================================
//  CHANGEMENT PERMISSION
// ============================================================
if (isset($_POST['action']) && $_POST['action'] === 'changer_perm') {

    $id            = (int) $_POST['id_u'];
    $nouvelle_perm = (int) $_POST['nouvelle_perm'];

    if ($id === (int) $_SESSION['id_u'] && $nouvelle_perm === ROLE_USER) {
        $message  = "Vous ne pouvez pas vous retirer les droits admin.";
        $type_msg = "erreur";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE users SET perm = ? WHERE id_u = ?");
        mysqli_stmt_bind_param($stmt, "ii", $nouvelle_perm, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $message  = ($nouvelle_perm === ROLE_ADMIN)
            ? "Utilisateur promu administrateur ✓"
            : "Utilisateur rétrogradé en utilisateur ✓";
        $type_msg = "succes";
    }
}

// ============================================================
//  RECHERCHE
// ============================================================
$recherche = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($recherche !== '') {
    $like = "%" . $recherche . "%";
    $stmt = mysqli_prepare($conn, "
        SELECT id_u, pseudo, nom, email, phone, perm, ville, photo_profil
        FROM users
        WHERE pseudo LIKE ? OR email LIKE ? OR nom LIKE ?
        ORDER BY perm ASC, pseudo ASC
    ");
    mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($conn, "
        SELECT id_u, pseudo, nom, email, phone, perm, ville, photo_profil
        FROM users
        ORDER BY perm ASC, pseudo ASC
    ");
}

$utilisateurs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $utilisateurs[] = $row;
}

// ============================================================
//  STATS
// ============================================================
$total = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];

$nb_admins = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE perm = " . ROLE_ADMIN)
)[0];

$nb_users = $total - $nb_admins;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Panel Admin</h2>
    <p>Connecté : <strong><?= htmlspecialchars($_SESSION['pseudo']) ?></strong></p>

    <hr>

    <p>Total : <?= $total ?> | Admins : <?= $nb_admins ?> | Users : <?= $nb_users ?></p>

    <?php if ($message): ?>
        <div class="alert alert-<?= $type_msg == 'succes' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="GET">
        <input type="text" name="q" placeholder="Recherche..."
               value="<?= htmlspecialchars($recherche) ?>" class="form-control mb-3">
    </form>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Perm</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($utilisateurs as $u): ?>
        <?php $estMoi = $u['id_u'] == $_SESSION['id_u']; ?>

        <tr>
            <!-- ✅ Corrigé : $u['pseudo'] au lieu de $_SESSION['pseudo'] -->
            <td><?= htmlspecialchars($u['pseudo'] ?? '') ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>

            <td>
                <?= $u['perm'] == ROLE_ADMIN ? 'Admin' : 'User' ?>
            </td>

            <td>

                <?php if ($u['perm'] != ROLE_ADMIN): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="changer_perm">
                        <input type="hidden" name="id_u" value="<?= $u['id_u'] ?>">
                        <input type="hidden" name="nouvelle_perm" value="<?= ROLE_ADMIN ?>">
                        <button class="btn btn-success btn-sm">Promouvoir</button>
                    </form>
                <?php else: ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="changer_perm">
                        <input type="hidden" name="id_u" value="<?= $u['id_u'] ?>">
                        <input type="hidden" name="nouvelle_perm" value="<?= ROLE_USER ?>">
                        <button class="btn btn-warning btn-sm" <?= $estMoi ? 'disabled' : '' ?>>
                            Rétrograder
                        </button>
                    </form>
                <?php endif; ?>

                <?php if (!$estMoi): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="id_u" value="<?= $u['id_u'] ?>">
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                <?php endif; ?>

            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>

<?php mysqli_close($conn); ?>