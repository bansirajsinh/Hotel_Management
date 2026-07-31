<?php
/**
 * Room Booking Confirmation
 * 
 * Displays room details and processes the booking request.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";

if (isset($_POST['book'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $message = "Invalid CSRF token.";
    } else {
        $conn = getDBConnection();

        $Pname = $_SESSION['user'];
        $Pemail = $_SESSION['email'];
        $datetime = $_GET['dateTime'] ?? '';
        $Room = $_GET['name'] ?? '';
        $id = $_GET['id'] ?? '';

        // 1. Insert into booking request
        $stmt_insert = mysqli_prepare($conn, "INSERT INTO `room_book_request` (`Person_name`, `Person_email`, `datetime`, `Room_name`) VALUES (?, ?, ?, ?)");
        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "ssss", $Pname, $Pemail, $datetime, $Room);
            if (mysqli_stmt_execute($stmt_insert)) {
                // 2. Update room_check status
                $stmt_update = mysqli_prepare($conn, "UPDATE `room_check` SET `is_booked` = 1 WHERE `id` = ?");
                if ($stmt_update) {
                    mysqli_stmt_bind_param($stmt_update, "i", $id);
                    if (mysqli_stmt_execute($stmt_update)) {
                        $message = "Room Booked Successfully!";
                    } else {
                        $message = "Booking request received, but failed to update room status.";
                    }
                    mysqli_stmt_close($stmt_update);
                }
            } else {
                $message = "Failed to submit booking request.";
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management - Book Room</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    
    <div class="book">
      <h3><?php echo htmlspecialchars($message); ?></h3>
      <table>
        <tr>
          <td>Room Name :</td>
          <td><?php echo htmlspecialchars($_GET['name'] ?? ''); ?></td>
        </tr>
        <tr>
          <td>Date And Time :</td>
          <td><?php echo htmlspecialchars($_GET['dateTime'] ?? ''); ?></td>
        </tr>
        <tr>
          <td>Adult Size :</td>
          <td><?php echo htmlspecialchars($_GET['Asize'] ?? ''); ?></td>
        </tr>
        <tr>
          <td>Child Size :</td>
          <td><?php echo htmlspecialchars($_GET['Csize'] ?? ''); ?></td>
        </tr>
        <tr>
          <form method="post">
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
              <td colspan="2" style="text-align:center; background-color:green">
                  <?php if (empty($message)): ?>
                      <input type="submit" value="Book Now" name="book">
                  <?php else: ?>
                      <a href="../pages/rooms.php" style="color:white; text-decoration:none;">Go Back to Rooms</a>
                  <?php endif; ?>
              </td>
          </form>
        </tr>
      </table>
  </div>

<script>
    function toggleMenu() {
        const menu = document.querySelector(".nav ul");
        menu.classList.toggle("active");
    }
</script>
</body>
</html>
