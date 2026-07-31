<?php 
/**
 * Signup Page
 * 
 * Handles new user registration.
 * Redirects authenticated users to the home page.
 * 
 * @package HotelManagement
 */

session_start();

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

if (isset($_POST['signup'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error_msg = "Invalid CSRF token.";
    } else {
        $conn = getDBConnection();
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['passwordI'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm_password) {
            $error_msg = "Passwords do not match!";
        } else {
            // Check if email exists
            $check_stmt = mysqli_prepare($conn, "SELECT id FROM user_db WHERE email = ?");
            if ($check_stmt) {
                mysqli_stmt_bind_param($check_stmt, "s", $email);
                mysqli_stmt_execute($check_stmt);
                $check_result = mysqli_stmt_get_result($check_stmt);
                
                if (mysqli_num_rows($check_result) > 0) {
                    $error_msg = "Email is already registered. Please login.";
                } else {
                    // Hash the password securely
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $currentDateTime = date('Y-m-d H:i:s');

                    $insert_stmt = mysqli_prepare($conn, "INSERT INTO user_db (name, email, password, datetime, Last_Login) VALUES (?, ?, ?, ?, ?)");
                    if ($insert_stmt) {
                        mysqli_stmt_bind_param($insert_stmt, "sssss", $username, $email, $hashed_password, $currentDateTime, $currentDateTime);
                        
                        if (mysqli_stmt_execute($insert_stmt)) {
                            // Registration successful, log them in
                            $_SESSION['user_id'] = mysqli_insert_id($conn);
                            $_SESSION['user'] = $username;
                            $_SESSION['email'] = $email;
                            
                            header('Location: home.php');
                            exit();
                        } else {
                            $error_msg = "Could not register user. Please try again.";
                        }
                        mysqli_stmt_close($insert_stmt);
                    } else {
                        $error_msg = "Database error. Please try again.";
                    }
                }
                mysqli_stmt_close($check_stmt);
            } else {
                $error_msg = "Database error. Please try again.";
            }
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
    <title>Hotel Management - Sign Up</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

    <div class="signup-page">
        <div class="signup-container">
            <h2>Sign Up</h2>
            <?php if (!empty($error_msg)): ?>
                <div style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_msg); ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="passwordI" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="submit" value="Sign Up" name="signup">
            </form>
            <div class="message">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>

</body>
</html>
