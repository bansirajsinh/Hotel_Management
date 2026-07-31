<?php
/**
 * Banquets Listing Page
 * 
 * Displays available banquet halls for a selected date.
 * Green = available, Red = booked.
 * 
 * @package HotelManagement
 */

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$date = '';
$banquets = [];
$searched = false;

if (isset($_POST['Submit'])) {
    $date = $_POST['date'] ?? '';
    
    if (!empty($date)) {
        $searched = true;
        
        $conn = getDBConnection();
        
        // 1. Check if we already have records for this date
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM `banquet_check` WHERE `date` = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $date);
        mysqli_stmt_execute($stmt_check);
        $res_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($res_check) == 0) {
            // 2. We don't have records, copy from master banquet table
            $query2 = "SELECT * FROM `banquet`";
            $result2 = mysqli_query($conn, $query2);
            
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO `banquet_check` (`name`, `Banquet_size`, `ac-no`, `Banquet_include`, `price`, `photo`, `date`, `is_booked`) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
            
            while ($i = mysqli_fetch_array($result2)) {
                $name = $i['name'];
                $size = $i['Banquet_size'];
                $ac_no = $i['ac-no'];
                $include = $i['Banquet_include'];
                $price = $i['price'];
                $photo = $i['photo'];
                
                mysqli_stmt_bind_param($stmt_insert, "sisssss", $name, $size, $ac_no, $include, $price, $photo, $date);
                mysqli_stmt_execute($stmt_insert);
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        
        // 3. Fetch availability for display
        $stmt_fetch = mysqli_prepare($conn, "SELECT * FROM `banquet_check` WHERE `date` = ?");
        mysqli_stmt_bind_param($stmt_fetch, "s", $date);
        mysqli_stmt_execute($stmt_fetch);
        $result_fetch = mysqli_stmt_get_result($stmt_fetch);
        
        while ($row = mysqli_fetch_assoc($result_fetch)) {
            $banquets[] = $row;
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
    <title>Hotel Management - Book Banquets</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <form method="post" style="margin: 20px;">
        <input type="date" name="date" required> <br>
        <input type="submit" value="Check Availability" name="Submit">
    </form>

    <?php if ($searched): ?>
        <h3 style="margin-left: 20px;">Availability for: <?php echo htmlspecialchars($date); ?></h3>
        <div class="booking-grid">
            <?php foreach ($banquets as $banquet): ?>
                <?php
                $name = htmlspecialchars($banquet['name']);
                $size = (int)$banquet['Banquet_size'];
                $ac_no = htmlspecialchars($banquet['ac-no']);
                $include = htmlspecialchars($banquet['Banquet_include']);
                $price = htmlspecialchars($banquet['price']);
                $photo = htmlspecialchars($banquet['photo']);
                $isB = (int)$banquet['is_booked'];
                $id = (int)$banquet['id'];
                $Dt = urlencode($date);
                $name_url = urlencode($banquet['name']);
                $ac_no_url = urlencode($banquet['ac-no']);
                $include_url = urlencode($banquet['Banquet_include']);
                $photo_url = urlencode($banquet['photo']);
                $price_url = urlencode($banquet['price']);
                ?>
                
                <?php if ($isB === 0): ?>
                    <a href="../booking/banquet_booking.php?name=<?php echo $name_url; ?>&dateTime=<?php echo $Dt; ?>&size=<?php echo $size; ?>&id=<?php echo $id; ?>&ac_no=<?php echo $ac_no_url; ?>&photo=<?php echo $photo_url; ?>&include=<?php echo $include_url; ?>&price=<?php echo $price_url; ?>">
                        <div class="tblN" title="Available">
                            <?php echo $name; ?><br>
                            <small>Capacity: <?php echo $size; ?> | <?php echo $ac_no; ?></small>
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
