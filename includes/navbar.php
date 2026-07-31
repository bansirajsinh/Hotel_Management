<?php
/**
 * Navigation Bar Component
 * 
 * Shared navigation bar included on all authenticated pages.
 * Handles the logout functionality and responsive menu toggle.
 * 
 * @package Booker
 */
?>
<div class="main">
    <div class="nav">
        <h3 class="name">Booker</h3>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <ul>
            <li><a href="../pages/home.php">HOME</a></li>
            <li><a href="../pages/about.php">ABOUT US</a></li>
            <li><a href="../pages/rooms.php">ROOMS</a></li>
            <li><a href="../pages/contact.php">CONTACT US</a></li>
            <li>
                <form action="../pages/login.php?log=1" method="post">
                    <input type="submit" value="Logout" name="lg">
                </form>
                <?php 
                if (isset($_POST['lg'])) {
                    setcookie('user', '', time() - 3600);
                    setcookie('email', '', time() - 3600);
                    setcookie('password', '', time() - 3600);

                    unset($_COOKIE['user']);
                    unset($_COOKIE['email']);
                    unset($_COOKIE['password']);
                }
                ?>
            </li>
        </ul>
    </div>
</div>
