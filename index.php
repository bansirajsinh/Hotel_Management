<?php 
/**
 * Booker — Entry Point
 * 
 * Routes authenticated users to the home page,
 * and unauthenticated users to the login page.
 * 
 * @package Booker
 */

if (isset($_COOKIE['user']) && isset($_COOKIE['password']) && isset($_COOKIE['email'])) {
    header('Location: pages/home.php');
} else {
    header('Location: pages/login.php');
}
exit();
?>