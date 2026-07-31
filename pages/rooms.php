<?php
/**
 * Rooms Listing Page
 * 
 * Displays available rooms for a selected date/time.
 * Green = available, Red = booked.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$datetime = '';
$rooms = [];
$searched = false;

if (isset($_POST['Submit'])) {
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    
    if (!empty($date) && !empty($time)) {
        $datetime = trim($date . " " . $time);
        $searched = true;
        
        $conn = getDBConnection();
        
        // 1. Check if we already have records for this datetime
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM `room_check` WHERE `date_time` = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $datetime);
        mysqli_stmt_execute($stmt_check);
        $res_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($res_check) == 0) {
            // 2. We don't have records, copy from master rooms_db
            $query2 = "SELECT * FROM `rooms_db`";
            $result2 = mysqli_query($conn, $query2);
            
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO `room_check` (`Room_name`, `is_booked`, `date_time`, `room_a_size`, `room_c_size`, `Category`, `photo`) VALUES (?, 0, ?, ?, ?, ?, ?)");
            
            while ($i = mysqli_fetch_array($result2)) {
                $name = $i['Room_name'];
                $Asize = $i['room_a_size'];
                $Csize = $i['room_c_size'];
                $category = $i['Category'];
                $photo = $i['photo'];
                
                mysqli_stmt_bind_param($stmt_insert, "ssiiss", $name, $datetime, $Asize, $Csize, $category, $photo);
                mysqli_stmt_execute($stmt_insert);
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        
        // 3. Fetch availability for display (fixing the original table_check bug)
        $stmt_fetch = mysqli_prepare($conn, "SELECT * FROM `room_check` WHERE `date_time` = ?");
        mysqli_stmt_bind_param($stmt_fetch, "s", $datetime);
        mysqli_stmt_execute($stmt_fetch);
        $result_fetch = mysqli_stmt_get_result($stmt_fetch);
        
        while ($row = mysqli_fetch_assoc($result_fetch)) {
            $rooms[] = $row;
        }
        mysqli_stmt_close($stmt_fetch);
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management - Book Rooms</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <form method="post" style="margin: 20px;">
        <input type="date" name="date" required> <br>
        <select name="time" required>
            <option value="10:00">10:00</option>
            <option value="22:00">22:00</option>
        </select>
        <input type="submit" value="Check Availability" name="Submit">
    </form>

    <?php if ($searched): ?>
        <h3 style="margin-left: 20px;">Availability for: <?php echo htmlspecialchars($datetime); ?></h3>
        <div class="booking-grid">
            <?php foreach ($rooms as $room): ?>
                <?php
                $name = htmlspecialchars($room['Room_name']);
                $Asize = (int)$room['room_a_size'];
                $Csize = (int)$room['room_c_size'];
                $isB = (int)$room['is_booked'];
                $id = (int)$room['id'];
                $Dt = urlencode($datetime);
                $name_url = urlencode($room['Room_name']);
                ?>
                
                <?php if ($isB === 0): ?>
                    <a href="../booking/room_booking.php?name=<?php echo $name_url; ?>&dateTime=<?php echo $Dt; ?>&Csize=<?php echo $Csize; ?>&id=<?php echo $id; ?>&Asize=<?php echo $Asize; ?>">
                        <div class="tblN" title="Available">
                            <?php echo $name; ?><br>
                            <small>Adults: <?php echo $Asize; ?> | Kids: <?php echo $Csize; ?></small>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="tblB" title="Booked">
                        <?php echo $name; ?><br>
                        <small>Booked</small>
                    </div>
                <?php endif; ?>
                
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<script>
    function toggleMenu() {
        const menu = document.querySelector(".nav ul");
        menu.classList.toggle("active");
    }
</script>
</body>
</html>
