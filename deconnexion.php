<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>logout</title>
</head>
<body>
    <?php
session_start();
session_destroy();
header("Location: connexion.php");
exit();
?>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
