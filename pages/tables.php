<?php
/**
 * Tables Listing Page
 * 
 * Displays available restaurant tables for a selected date/time.
 * Green = available, Red = booked.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$datetime = '';
$tables = [];
$searched = false;

if (isset($_POST['Submit'])) {
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    
    if (!empty($date) && !empty($time)) {
        $datetime = trim($date . " " . $time);
        $searched = true;
        
        $conn = getDBConnection();
        
        // 1. Check if we already have records for this datetime
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM `table_check` WHERE `date_time` = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $datetime);
        mysqli_stmt_execute($stmt_check);
        $res_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($res_check) == 0) {
            // 2. We don't have records, copy from master tables
            $query2 = "SELECT * FROM `tables`";
            $result2 = mysqli_query($conn, $query2);
            
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO `table_check` (`name`, `is_booked`, `date_time`, `size`) VALUES (?, 0, ?, ?)");
            
            while ($i = mysqli_fetch_array($result2)) {
                $name = $i['Table_name'];
                $size = $i['Table_size'];
                
                mysqli_stmt_bind_param($stmt_insert, "ssi", $name, $datetime, $size);
                mysqli_stmt_execute($stmt_insert);
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        
        // 3. Fetch availability for display
        $stmt_fetch = mysqli_prepare($conn, "SELECT * FROM `table_check` WHERE `date_time` = ?");
        mysqli_stmt_bind_param($stmt_fetch, "s", $datetime);
        mysqli_stmt_execute($stmt_fetch);
        $result_fetch = mysqli_stmt_get_result($stmt_fetch);
        
        while ($row = mysqli_fetch_assoc($result_fetch)) {
            $tables[] = $row;
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
    <title>Hotel Management - Book Table</title>
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
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
            <option value="20:00">20:00</option>
            <option value="21:00">21:00</option>
            <option value="22:00">22:00</option>
            <option value="23:00">23:00</option>
        </select>
        <input type="submit" value="Check Availability" name="Submit">
    </form>

    <?php if ($searched): ?>
        <h3 style="margin-left: 20px;">Availability for: <?php echo htmlspecialchars($datetime); ?></h3>
        <div class="booking-grid">
            <?php foreach ($tables as $table): ?>
                <?php
                $name = htmlspecialchars($table['name']);
                $size = (int)$table['size'];
                $isB = (int)$table['is_booked'];
                $id = (int)$table['id'];
                $Dt = urlencode($datetime);
                $name_url = urlencode($table['name']);
                ?>
                
                <?php if ($isB === 0): ?>
                    <a href="../booking/table_booking.php?name=<?php echo $name_url; ?>&dateTime=<?php echo $Dt; ?>&size=<?php echo $size; ?>&id=<?php echo $id; ?>">
                        <div class="tblN" title="Available">
                            <?php echo $name; ?><br>
                            <small>Seats: <?php echo $size; ?></small>
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
