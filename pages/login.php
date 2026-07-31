<?php 
/**
 * Login Page
 * 
 * Handles user authentication via email & password.
 * Redirects authenticated users to the home page.
 * 
 * @package HotelManagement
 */

session_start();

// Handle logout request via GET log=1
if (isset($_GET['log'])) {
    session_unset();
    session_destroy();
    // Clear old cookies just in case
    setcookie('user', '', time() - 3600, '/');
    setcookie('email', '', time() - 3600, '/');
    setcookie('password', '', time() - 3600, '/');
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
} 

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Include database config
require_once __DIR__ . '/../config/database.php';
$error_msg = "";

if (isset($_POST['Submit'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error_msg = "Invalid CSRF token.";
    } else {
        $conn = getDBConnection();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Prepared statement to prevent SQL Injection
        $stmt = mysqli_prepare($conn, "SELECT id, name, email, password FROM user_db WHERE email = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Verify password hash
                if (password_verify($password, $row['password'])) {
                    // Password correct, set session
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user'] = $row['name'];
                    $_SESSION['email'] = $row['email'];

                    // Update last login
                    $update_stmt = mysqli_prepare($conn, "UPDATE user_db SET Last_Login = NOW() WHERE id = ?");
                    if ($update_stmt) {
                        mysqli_stmt_bind_param($update_stmt, "i", $row['id']);
                        mysqli_stmt_execute($update_stmt);
                        mysqli_stmt_close($update_stmt);
                    }

                    header('Location: home.php');
                    exit();
                } else {
                    $error_msg = "Email Or Password Is Wrong!";
                }
            } else {
                $error_msg = "Email Or Password Is Wrong!";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_msg = "Database error. Please try again later.";
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management - Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error_msg)): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name="Submit">
        </form>
        <div class="message">
            <p>Not registered? <a href="signup.php">Create an account</a></p>
        </div>
    </div>
</div>

</body>
</html>
