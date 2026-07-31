<?php
/**
 * About Us Page
 * 
 * Displays information about the Booker team and
 * provides a contact form.
 * 
 * @package Booker
 */

require_once __DIR__ . '/../config/database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booker - About Us</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="contact-page">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <?php if (isset($successMessage)) : ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php else : ?>
                <form action="" method="post">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <input type="submit" value="Send Message" name="send">
                </form>
            <?php endif; ?>
            <?php 
                if (isset($_POST['send'])) {
                    extract($_POST);
                    $conn = getDBConnection();

                    $query = "INSERT INTO `contact_us` (`id`, `name`, `email`, `message`) VALUES (NULL, '$name', '$email', '$message')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        echo "We Will Contact You";
                    }

                    mysqli_close($conn);
                }
            ?>
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
