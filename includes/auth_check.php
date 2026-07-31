<?php
/**
 * Authentication Check
 * 
 * Include this file at the top of any page that requires
 * the user to be logged in. Redirects to the login page
 * if the user is not authenticated.
 * 
 * @package Booker
 */

if (empty($_COOKIE['user']) || empty($_COOKIE['password']) || empty($_COOKIE['email'])) {
    header('Location: ' . dirname(__DIR__) . '/pages/login.php');
    // Use a relative URL that works from any subdirectory
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    // Go up one level if we're in a subdirectory (pages/, booking/)
    $loginUrl = dirname($baseUrl) . '/pages/login.php';
    header('Location: ' . $loginUrl);
    exit();
}
?>
