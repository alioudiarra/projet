<?php

// CONNEXION À LA BASE "projet" 
$conn = mysqli_connect("localhost", "root", "root", "projet");
//my fonction qui cree la connexion 


// 3. TRAITEMENT DU FORMULAIRE
if (isset($_POST['register'])) {
    
    // Récupération et protection des données
    //mysqli_real_escape_string(c'est pour nettoyer les fonctions speciaux(comme les guillemets)
    $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
    $nom    = mysqli_real_escape_string($conn, $_POST['nom']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $perm   = 1; // Valeur par défaut pour ta colonne 'perm'

    // Hachage du mot de passe (pour la colonne 'mpd')
    $mpd_clair = $_POST['mpd'];
    $mpd_hache = password_hash($mpd_clair, PASSWORD_BCRYPT);

    // Vérifier si l'email existe déjà
    $check_email = mysqli_query($conn, "SELECT id_u FROM users WHERE email = '$email'");

    if (mysqli_num_rows($check_email) == 0) {
        // INSERTION (Respecte l'ordre de tes colonnes : id_u est auto-incrémenté donc on ne le met pas)
        $sql = "INSERT INTO users (pseudo, nom, email, mpd, phone, perm) 
                VALUES ('$pseudo', '$nom', '$email', '$mpd_hache', '$phone', '$perm')";

        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color:green; font-weight:bold;'>Succès ! Utilisateur enregistré dans la base 'projet'.</p>";
        } else {
            $message = "<p style='color:red;'>Erreur SQL : " . mysqli_error($conn) . "</p>";
        }
    } else {
        $message = "<p style='color:orange;'>Cet email est déjà utilisé.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - LeBonCoin Projet</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 350px; }
        h2 { text-align: center; color: #ff3f34; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #ff3f34; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        button:hover { background-color: #e0362c; }
        .msg { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Créer un compte</h2>
        
        <div class="msg"><?php echo $message; ?></div>

        <form action="" method="POST">
            <input type="text" name="pseudo" placeholder="Pseudo" required>
            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="email" name="email" placeholder="Adresse Email" required>
            <input type="tel" name="phone" placeholder="Numéro de téléphone">
            <input type="password" name="mpd" placeholder="Mot de passe" required>
            
            <button type="submit" name="register">S'inscrire</button>
        </form>
        
       <p style="font-size: 0.8em; text-align: center;">
            Déjà inscrit ? <a href="connexion.php">Se connecter</a>
        </p> 
    </div>

</body>
</html>