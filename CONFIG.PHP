<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On définit le rôle s'il n'existe pas déjà
if (!defined('ROLE_ADMIN')) {
    define('ROLE_ADMIN', 0); 
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        
        return isset($_SESSION['perm']) && $_SESSION['perm'] == ROLE_ADMIN;
    }
}
?>