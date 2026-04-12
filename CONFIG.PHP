<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On définit le rôle s'il n'existe pas déjà
if (!defined('ROLE_ADMIN')) {
    define('ROLE_ADMIN', 0); 
}

// ON VÉRIFIE SI LA FONCTION EXISTE DÉJÀ AVANT DE LA CRÉER
if (!function_exists('isAdmin')) {
    function isAdmin() {
        // Attention : vérifie bien si pour toi Admin = 0 ou Admin = 1 
        // car dans tes fichiers précédents tu utilisais 1 pour l'admin.
        return isset($_SESSION['perm']) && $_SESSION['perm'] == ROLE_ADMIN;
    }
}
?>