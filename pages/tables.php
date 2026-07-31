<?php
/**
 * Tables Listing Page
 * 
 * Displays available restaurant tables for a selected date/time.
 * Green = available, Red = booked.
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
    <title>Booker - Book Table</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <form method="post">
        <input type="date" name="date"> <br>
        <select name="time">
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
        <input type="submit" value="Submit" name="Submit">
    </form>

    <?php 
        if (isset($_POST['Submit'])) {
            extract($_POST);
            $datetime = $date . " " . $time;
            echo $datetime;

            $conn = getDBConnection();
            $flg = 1;

            $query = "SELECT * FROM `table_check` WHERE `date_time`='$datetime'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query2 = "SELECT * FROM `tables`";
                $result2 = mysqli_query($conn, $query2);

                while ($i = mysqli_fetch_array($result2)) {
                    $name = $i['Table_name'];
                    $size = $i['Table_size'];
                    $isB = 0;
                    $Dt = $datetime;

                    $query3 = "INSERT INTO `table_check` (`id`, `name`, `isbooked`, `date_time`, `size`) VALUES (NULL, '$name', '$isB', '$Dt', '$size')"; 
                    $result3 = mysqli_query($conn, $query3);
                    if ($result3) {
                        $flg = 1;
                    }
                }

                if ($flg == 1) {
                    $query4 = "SELECT * FROM `table_check` WHERE `date_time`='$datetime'";
                    $result4 = mysqli_query($conn, $query);
                    echo "<div class=\"booking-grid\">";

                    while ($j = mysqli_fetch_array($result4)) {
                        $name = $j['name'];
                        $size = $j['size'];
                        $isB = $j['isbooked'];
                        $Dt = $j['date_time'];
                        $id = $j['id'];

                        if ($isB == 0) {
                            echo "<a href=\"../booking/table_booking.php?name=$name&dateTime=$Dt&size=$size&id=$id\"><div class=\"tblN\">$name</div></a>";
                        } else {
                            echo "<div class=\"tblB\">$name</div>";
                        }
                    }
                    echo "</div>";
                } 
            }

            echo "<div class=\"booking-grid\">";
            while ($k = mysqli_fetch_array($result)) {
                $name = $k['name'];
                $size = $k['size'];
                $isB = $k['isbooked'];
                $Dt = $k['date_time'];
                $id = $k['id'];

                if ($isB == 0) {
                    echo "<a href=\"../booking/table_booking.php?name=$name&dateTime=$Dt&size=$size&id=$id\"><div class=\"tblN\">$name</div></a>";
                } else {
                    echo "<div class=\"tblB\">$name</div>";
                }
            }
            echo "</div>";

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
