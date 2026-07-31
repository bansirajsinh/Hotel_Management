<?php 
/**
 * Signup Page
 * 
 * Handles new user registration.
 * Redirects authenticated users to the home page.
 * 
 * @package Booker
 */

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
    <title>Booker - Sign Up</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

    <div class="signup-page">
        <div class="signup-container">
            <h2>Sign Up</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="passwordI" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="submit" value="Sign Up" name="signup">
            </form>
            <div class="message">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
            
<?php 
    if (isset($_POST['signup'])) {
        extract($_POST);

        $currentDateTime = date('Y-m-d H:i:s');
        $conn = getDBConnection();

        if ($passwordI == $confirm_password) {
            $query_login = "SELECT * FROM `user_db`";
            $result2 = mysqli_query($conn, $query_login);
            $found = 0;

            while ($i = mysqli_fetch_array($result2)) {
                if ($i['email'] == $email && $i['password'] == $passwordI) {
                    $found = 1;
                    header('Location: login.php');
                    exit();
                }
            }
                      
            $query = "INSERT INTO `user_db` (`id`, `name`, `email`, `password`, `datetime`,`Last_Login`) VALUES (NULL, '$username', '$email', '$passwordI', '$currentDateTime','$currentDateTime')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                setcookie('user', $username, time() + (86400 * 30));
                setcookie('email', $email, time() + (86400 * 30));
                setcookie('password', $passwordI, time() + (86400 * 30));
                header('Location: home.php');
                exit();
            } else {
                echo "Couldn't Sign up";
            }
        } else {
            echo "Password doesn't Match!";
        }

        mysqli_close($conn);
    }
?>
        </div>
    </div>

</body>
</html>
