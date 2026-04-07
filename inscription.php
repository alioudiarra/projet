<?php
<<<<<<< HEAD
session_start();//pour rester connecter a chaque fois 
=======
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
>>>>>>> 2502880da73206ff05323aeae04a06df0ae3a893
// CONNEXION À LA BASE "projet" 
$conn = mysqli_connect("localhost", "root", "root", "projet");
if (!$conn) {
    die("Erreur connexion : " . mysqli_connect_error());
}
//AJOUT $MESSAGE POUR EVITER LES BUG 
$message = "";

// TRAITEMENT DU FORMULAIRE
if (isset($_POST['register'])) {
    
    $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
    $nom    = mysqli_real_escape_string($conn, $_POST['nom']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $ville  = mysqli_real_escape_string($conn, $_POST['ville']);
    $perm   = 1;

    $mpd_clair = $_POST['mpd'];
    $mpd_hache = password_hash($mpd_clair, PASSWORD_BCRYPT);//hachage

    // Vérifier si l'email existe déjà
    $check_email = mysqli_query($conn, "SELECT id_u FROM users WHERE email = '$email'");

    if (mysqli_num_rows($check_email) == 0) {
        $sql = "INSERT INTO users (pseudo, nom, email, mpd, phone, ville, perm) 
                VALUES ('$pseudo', '$nom', '$email', '$mpd_hache', '$phone', '$ville', '$perm')";//valeurs des variables 

        if (mysqli_query($conn, $sql)) {
            $id_u = mysqli_insert_id($conn);

            $_SESSION['id_u']    = $id_u;
            $_SESSION['pseudo']  = $pseudo;
            $_SESSION['nom']     = $nom;
            $_SESSION['email']   = $email;

            header("Location: profile.php");
            exit();
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
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
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
            <input type="text"  name="pseudo" placeholder="Pseudo" required>
            <input type="text"  name="nom"    placeholder="Nom complet" required>
            <input type="email" name="email"  placeholder="Adresse Email" required>
            <input type="tel"   name="phone"  placeholder="Numéro de téléphone">
            <input type="text"  name="ville"  placeholder="Ville">
            <input type="password" name="mpd" placeholder="Mot de passe" required>
            
            <button type="submit" name="register">S'inscrire</button>
        </form>
        
        <p style="font-size: 0.8em; text-align: center;">
            Déjà inscrit ? <a href="connexion.php">Se connecter</a>
        </p> 
    </div>

</body>
</html>