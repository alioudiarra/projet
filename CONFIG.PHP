<?php
session_start();
 
define('ROLE_ADMIN', 0); // 0 = admin, 1 = utilisateur simple
 
function isAdmin() {
    return isset($_SESSION['perm']) && $_SESSION['perm'] == ROLE_ADMIN;
}
 