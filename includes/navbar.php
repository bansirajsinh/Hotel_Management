<?php
/**
 * Navigation Bar Component
 * 
 * Shared navigation bar included on all authenticated pages.
 * Handles the logout functionality and responsive menu toggle.
 * 
 * @package HotelManagement
 */
?>
<div class="main">
    <div class="nav">
        <h3 class="name">Hotel Management</h3>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <ul>
            <li><a href="../pages/home.php">HOME</a></li>
            <li><a href="../pages/about.php">ABOUT US</a></li>
            <li><a href="../pages/rooms.php">ROOMS</a></li>
            <li><a href="../pages/contact.php">CONTACT US</a></li>
            <li>
                <form action="../pages/login.php?log=1" method="post">
                    <input type="submit" value="Logout" name="lg" style="background: none; border: none; color: white; cursor: pointer; font-family: inherit; font-size: inherit;">
                </form>
                <?php 
                if (isset($_POST['lg'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    session_unset();
                    session_destroy();
                    // Clear old cookies just in case users still have them
                    setcookie('user', '', time() - 3600, '/');
                    setcookie('email', '', time() - 3600, '/');
                    setcookie('password', '', time() - 3600, '/');
                    
                    header('Location: ../pages/login.php');
                    exit();
                }
                ?>
            </li>
        </ul>
    </div>
</div>
