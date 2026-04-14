<?php
session_start();
require_once 'database.php';

// Sécurité : on vérifie que les paramètres existent
if(!isset($_GET['id_a']) || !isset($_GET['id_vendeur']) || !isset($_SESSION['id_u'])) {
    header("Location: acceil.php");
    exit();
}

$id_annonce = (int)$_GET['id_a'];
$id_vendeur = (int)$_GET['id_vendeur']; 
$id_acheteur = (int)$_SESSION['id_u']; 

// Empêcher de se parler à soi-même
if ($id_acheteur === $id_vendeur) {
    header("Location: annonce_detail.php?id=$id_annonce&error=self");
    exit();
}

// 1. On cherche si une conversation existe déjà entre ces deux personnes pour CETTE annonce
// On vérifie les deux sens pour être sûr de ne pas créer de doublons
$check = mysqli_query($conn, "SELECT id_c FROM convers 
                             WHERE id_a = $id_annonce 
                             AND ((id_u1 = $id_acheteur AND id_u2 = $id_vendeur) 
                             OR (id_u1 = $id_vendeur AND id_u2 = $id_acheteur))");

if(mysqli_num_rows($check) > 0) {
    // La conversation existe déjà
    $conv = mysqli_fetch_assoc($check);
    $id_c = $conv['id_c'];
} else {
    // 2. Elle n'existe pas, on la crée
    $insert_conv = "INSERT INTO convers (id_a, id_u1, id_u2) VALUES ($id_annonce, $id_acheteur, $id_vendeur)";
    
    if(mysqli_query($conn, $insert_conv)) {
        $id_c = mysqli_insert_id($conn);
        
        // 3. ON ENVOIE LE PREMIER MESSAGE
        // Très important : c'est ce message qui rend la discussion visible pour les deux
        $premier_msg = mysqli_real_escape_string($conn, "Bonjour, je suis intéressé par votre annonce !");
        mysqli_query($conn, "INSERT INTO sms (id_u, sms, id_c, date_send) 
                             VALUES ($id_acheteur, '$premier_msg', $id_c, NOW())");
    } else {
        die("Erreur lors de la création de la discussion : " . mysqli_error($conn));
    }
}

// Redirection vers le chat
header("Location: chat.php?id_c=$id_c");
exit();