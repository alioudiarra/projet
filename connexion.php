<?php


session_start();
require_once 'database.php'; // C'est ici qu'est défini $conn
require_once 'CONFIG.PHP';  // Pour garder tes autres configurations

$erreur = "";

// Fonction demandée par ta page d'accueil
function isAdmin() {
    return isset($_SESSION['perm']) && $_SESSION['perm'] == 2;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
    $mpd_saisi = $_POST['mpd'];

    // On cherche l'utilisateur par son pseudo OU son email
    $sql = "SELECT * FROM users WHERE pseudo = '$pseudo' OR email = '$pseudo'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // VERIFICATION SECURISEE
        if (password_verify($mpd_saisi, $user['mpd'])) {
            // On remplit la session avec les infos de la base
            $_SESSION['id_u']   = $user['id_u'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['perm']   = $user['perm']; // Important pour isAdmin()

            header("Location: acceil.php");
            exit();
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Utilisateur introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - ElectroMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card m-auto p-5 rounded-3 shadow-lg w-50">
            <h1 class="mb-4">Login</h1>

            <?php if ($erreur): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Pseudo ou Email</label>
                    <input type="text" class="form-control" name="pseudo" value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="mpd" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Connexion</button>
            </form>
            <hr>
            <p class="text-center small">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>