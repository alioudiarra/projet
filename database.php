<?php
// CONEXION A LA BASE DE DONNER 
$conn = mysqli_connect("localhost", "root", "root", "projet");

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>