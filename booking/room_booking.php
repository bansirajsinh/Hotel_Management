<?php
/**
 * Room Booking Confirmation
 * 
 * Displays room details and processes the booking request.
 * 
 * @package Booker
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booker - Book Room</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    
    <div class="book"><h3></h3>
      <table>
        <tr>
          <td>Room Name :</td>
          <td>
            <?php
            if (isset($_GET['name'])) {
                echo $_GET['name'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>Date And Time :</td>
          <td>
            <?php
            if (isset($_GET['dateTime'])) {
                echo $_GET['dateTime'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>Adult Size :</td>
          <td>
            <?php
            if (isset($_GET['Asize'])) {
                echo $_GET['Asize'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>Child Size :</td>
          <td>
            <?php
            if (isset($_GET['Csize'])) {
                echo $_GET['Csize'];
            }
            ?>
          </td>
        </tr>
        <tr>
          <form method="post">
          <td colspan="2" style="text-align:center; background-color:green"><input type="submit" value="Book Now" name="book"></td>
          </form>
        </tr>
      </table>
  </div>

  <?php 
  if (isset($_POST['book'])) {
    $conn = getDBConnection();

    $Pname = $_COOKIE['user'];
    $Pemail = $_COOKIE['email'];
    $datetime = $_GET['dateTime'];
    $Room = $_GET['name'];
    $id = $_GET['id'];

    $qur = "INSERT INTO `room_book_request` (`id`, `Person_name`, `Person_email`, `datetime`, `Room_name`) VALUES (NULL, '$Pname', '$Pemail', '$datetime', '$Room')";
    $result = mysqli_query($conn, $qur);

    if ($result) {
      $qur2 = "UPDATE `room_check` SET `isbooked`='1' WHERE `id`='$id'";
      $result2 = mysqli_query($conn, $qur2);
      if ($result2) {
        echo "Booked";
      }
    } else {
      echo "Not Booked";
    }

    mysqli_close($conn);
  }
  ?>

<script>
    function toggleMenu() {
        const menu = document.querySelector(".nav ul");
        menu.classList.toggle("active");
    }
</script>
</body>
</html>
