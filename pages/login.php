<?php 
/**
 * Login Page
 * 
 * Handles user authentication via email & password.
 * Redirects authenticated users to the home page.
 * 
 * @package Booker
 */

// Handle logout request
if (isset($_GET['log'])) {
    setcookie('user', '', time() - 3600);
    setcookie('email', '', time() - 3600);
    setcookie('password', '', time() - 3600);

    unset($_COOKIE['user']);
    unset($_COOKIE['email']);
    unset($_COOKIE['password']);
}

// Redirect if already logged in
if (isset($_COOKIE['user']) && isset($_COOKIE['password']) && isset($_COOKIE['email'])) {
    header('Location: home.php');
    exit();
} 

// Include database config
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booker - Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name="Submit">
        </form>
        <div class="message">
            <p>Not registered? <a href="signup.php">Create an account</a></p>
        </div>
        <?php
        if (isset($_POST['Submit'])) {
            $currentDateTime = date('Y-m-d H:i:s');
            $conn = getDBConnection();

            extract($_POST);
            $query_login = "SELECT * FROM `user_db`";
            $result = mysqli_query($conn, $query_login);
            $found = 0;

            while ($i = mysqli_fetch_array($result)) {
                if ($i['email'] == $email && $i['password'] == $password) {
                    $found = 1;

                    $us = $i['name'];
                    $em = $i['email'];
                    $ps = $i['password'];

                    setcookie('user', $us, time() + (86400 * 30));
                    setcookie('email', $em, time() + (86400 * 30));
                    setcookie('password', $ps, time() + (86400 * 30));

                    $Last_qur = "UPDATE `user_db` SET `Last_Login`='$currentDateTime' WHERE `email`='$email'";
                    $result2 = mysqli_query($conn, $Last_qur);

                    header('Location: home.php');
                    exit();
                }
            }

            if ($found == 0) {
                echo "Email Or Password Is Wrong!";
            }

            mysqli_close($conn);
        }
        ?>
    </div>
</div>

</body>
</html>
