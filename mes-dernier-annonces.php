<?php
// 1. Connexion à la base de données
// On teste avec "root" comme mot de passe (standard pour MAMP)
$conn = mysqli_connect("localhost", "root", "root", "projet");

// Si la connexion échoue, on tente sans mot de passe (standard pour XAMPP)
if (!$conn) {
    $conn = mysqli_connect("localhost", "root", "", "projet");
}

// Si ça ne marche toujours pas, on arrête tout et on affiche l'erreur
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// 2. Récupération des annonces
$sql = "SELECT * FROM annnonce ORDER BY id_a DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon ElectroMarket - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Les dernières annonces</h1>
    </header>

    <main class="grille-annonces">
        <?php
        // 3. Vérification s'il y a des annonces
        if (mysqli_num_rows($result) > 0) {
            
            // 4. Boucle pour afficher chaque annonce
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $row['img']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>
                    
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="type"><?php echo htmlspecialchars($row['type']); ?></p>
                        <p class="price"><?php echo number_format($row['price'], 0, ',', ' '); ?> €</p>
                        
                        <a href="article.php?id=<?php echo $row['id_a']; ?>" class="btn-voir">Voir l'annonce</a>
                    </div>
                </div>
                <?php
            }

        } else {
            echo "<p class='no-data'>Aucune annonce disponible pour le moment.</p>";
        }
        ?>
    </main>

</body>
</html>