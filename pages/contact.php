<?php
/**
 * Contact Us Page
 * 
 * Provides a contact form for visitors to send messages.
 * Stores messages in the database.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$successMessage = "";
$errorMessage = "";

// Check if the form is submitted
if (isset($_POST['send'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errorMessage = "Invalid CSRF token.";
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        if (!empty($name) && !empty($email) && !empty($message)) {
            $conn = getDBConnection();
            $stmt = mysqli_prepare($conn, "INSERT INTO `contact_us` (`name`, `email`, `message`) VALUES (?, ?, ?)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
                if (mysqli_stmt_execute($stmt)) {
                    $successMessage = "We Will Contact You Soon!";
                } else {
                    $errorMessage = "Failed to send message. Please try again.";
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
        } else {
            $errorMessage = "All fields are required.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management - Contact Us</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="contact-page">
        <div class="contact-container">
            <h2>Contact Us</h2>
            
            <?php if (!empty($errorMessage)): ?>
                <div style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($successMessage)): ?>
                <div class="success-message" style="color: green; margin-bottom: 15px; font-weight: bold;">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php else : ?>
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <input type="submit" value="Send Message" name="send">
                </form>
            <?php endif; ?>
        </div>
    </div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    function toggleMenu() {
        const menu = document.querySelector(".nav ul");
        menu.classList.toggle("active");
    }
</script>
</body>
</html>
