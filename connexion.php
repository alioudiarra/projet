<?php
require_once 'config.php'; // session_start() est déjà dans config.php

$db = mysqli_connect("localhost", "root", "root", "projet");

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo   = trim($_POST['pseudo'] ?? '');
    $password = $_POST['mpd'] ?? '';

    if ($pseudo === '' || $password === '') {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE pseudo = ?");
        mysqli_stmt_bind_param($stmt, "s", $pseudo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user   = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['mpd'])) {
            $_SESSION['id_u']   = $user['id_u'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['perm']   = $user['perm']; // ← enregistre la permission en session
            header("Location: acceil.php");
            exit();
        } else {
            $erreur = "Pseudo ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    a:hover { text-decoration: underline; }
</style>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="acceil.php">Le bon coin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="chat.php">Chat</a></li>
      </ul>
      <a class="btn btn-danger" href="register.php">
        Register <i class="fa-solid fa-person"></i>
      </a>
    </div>
  </div>
</nav>

<body>
<br>
<form class="bg-light m-auto p-5 rounded-3 shadow-lg w-50" action="" method="post">
    <h1>Login</h1>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Pseudo</label>
        <input type="text" class="form-control" name="pseudo"
               value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="mpd">
    </div>
    <button type="submit" class="btn btn-danger">Submit</button>
</form>
<br><hr>
</body>
</html>