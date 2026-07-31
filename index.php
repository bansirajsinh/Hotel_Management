<?php 
/**
 * Hotel Management — Entry Point
 * 
 * Routes authenticated users to the home page,
 * and unauthenticated users to the login page.
 * 
 * @package HotelManagement
 */

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: pages/home.php');
} else {
    header('Location: pages/login.php');
}
exit();
?>