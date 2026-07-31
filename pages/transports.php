<?php
/**
 * Transports Listing Page
 * 
 * Displays available transport services for a selected date/time.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$datetime = '';
$transports = [];
$searched = false;

if (isset($_POST['Submit'])) {
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    
    if (!empty($date) && !empty($time)) {
        $datetime = trim($date . " " . $time);
        $searched = true;
        
        $conn = getDBConnection();
        
        // 1. Check if we already have records for this datetime
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM `transport_check` WHERE `datetime` = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $datetime);
        mysqli_stmt_execute($stmt_check);
        $res_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($res_check) == 0) {
            // 2. We don't have records, copy from master transport table
            $query2 = "SELECT * FROM `transport`";
            $result2 = mysqli_query($conn, $query2);
            
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO `transport_check` (`CompanyName`, `CarName`, `is_booked`, `CarPrice`, `CarSize`, `description`, `photo`, `datetime`) VALUES (?, ?, 0, ?, ?, ?, ?, ?)");
            
            while ($i = mysqli_fetch_array($result2)) {
                $CompanyName = $i['CompanyName'];
                $CarName = $i['CarName'];
                $CarSize = $i['CarSize'];
                $CarPrice = $i['CarPrice'];
                $description = $i['description'];
                $photo = $i['photo'];
                
                mysqli_stmt_bind_param($stmt_insert, "ssdisss", $CompanyName, $CarName, $CarPrice, $CarSize, $description, $photo, $datetime);
                mysqli_stmt_execute($stmt_insert);
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        
        // 3. Fetch availability for display
        $stmt_fetch = mysqli_prepare($conn, "SELECT * FROM `transport_check` WHERE `datetime` = ?");
        mysqli_stmt_bind_param($stmt_fetch, "s", $datetime);
        mysqli_stmt_execute($stmt_fetch);
        $result_fetch = mysqli_stmt_get_result($stmt_fetch);
        
        while ($row = mysqli_fetch_assoc($result_fetch)) {
            $transports[] = $row;
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
    <title>Hotel Management - Book Transports</title>
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
            <?php foreach ($transports as $transport): ?>
                <?php
                $CompanyName = htmlspecialchars($transport['CompanyName']);
                $CarName = htmlspecialchars($transport['CarName']);
                $CarSize = (int)$transport['CarSize'];
                $isB = (int)$transport['is_booked'];
                $id = (int)$transport['id'];
                // Since there is no transport_booking.php in the original code but it showed the items, 
                // we'll just display them similar to the others. (The original just echoed text).
                ?>
                
                <?php if ($isB === 0): ?>
                    <div class="tblN" title="Available" style="cursor: default;">
                        <strong><?php echo $CompanyName; ?></strong><br>
                        <?php echo $CarName; ?><br>
                        <small>Seats: <?php echo $CarSize; ?></small>
                    </div>
                <?php else: ?>
                    <div class="tblB" title="Booked">
                        <strong><?php echo $CompanyName; ?></strong><br>
                        <?php echo $CarName; ?><br>
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
