<?php 

$conn = new mysqli("localhost", "root", "root", "projet"); 

$recherche = $_GET['q'] ?? ''; 

if (empty($recherche)) { 
    echo "Veuillez entrer un mot-clé"; 
    exit; 
} 

// ✅ 1. "annonce" (2 n)  2. backticks autour de `desc`
$sql = "SELECT * FROM annnonce WHERE title LIKE ? OR `desc` LIKE ?"; 

$stmt = $conn->prepare($sql); 
$search = "%" . $recherche . "%"; 
$stmt->bind_param("ss", $search, $search); 
$stmt->execute(); 
$result = $stmt->get_result(); 

?> 

<!DOCTYPE html> 
<html lang="fr"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Résultats</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 

<h1>Résultats pour "<?php echo htmlspecialchars($recherche); ?>"</h1> 

<div class="annonces"> 

<?php if ($result->num_rows > 0): ?> 
    <?php while ($row = $result->fetch_assoc()): ?> 
        <div class="annonce"> 
            <!-- ✅ 3. Noms de colonnes cohérents avec la BDD -->
            <h2><?= htmlspecialchars($row['title']); ?></h2> 
            <p><?= htmlspecialchars($row['desc']); ?></p> 
        </div> 
    <?php endwhile; ?> 
<?php else: ?> 
    <p>Aucune annonce trouvée</p> 
<?php endif; ?> 

</div> 

</body> 
</html> 

<?php 
$stmt->close(); 
$conn->close(); 
?>