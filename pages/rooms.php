<?php
/**
 * Rooms Listing Page
 * 
 * Displays available rooms for a selected date/time.
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
    <title>Booker - Book Rooms</title>
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
            <option value="22:00">22:00</option>
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

            $query = "SELECT * FROM `room_check` WHERE `date_time`='$datetime'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query2 = "SELECT * FROM `rooms_db`";
                $result2 = mysqli_query($conn, $query2);

                while ($i = mysqli_fetch_array($result2)) {
                    $name = $i['Room_name'];
                    $Asize = $i['room_a_size'];
                    $Csize = $i['room_c_size'];
                    $Description = $i['room_description'];
                    $category = $i['Category'];
                    $photo = $i['photo'];
                    $isB = 0;
                    $Dt = $datetime;

                    $query3 = "INSERT INTO `room_check` (`id`, `Room_name`, `isbooked`, `date_time`, `room_a_size`, `room_c_size`, `Category`, `photo`) VALUES (NULL, '$name', '$isB', '$Dt', '$Asize', '$Csize', '$category', '$photo')"; 
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
                        $name = $j['Room_name'];
                        $Asize = $j['room_a_size'];
                        $Csize = $j['room_c_size'];
                        $category = $j['Category'];
                        $photo = $j['photo'];
                        $isB = $j['isbooked'];    
                        $id = $j['id'];
                        $Dt = $datetime;

                        if ($isB == 0) {
                            echo "<a href=\"../booking/room_booking.php?name=$name&dateTime=$Dt&Csize=$Csize&id=$id&Asize=$Asize\"><div class=\"tblN\">$name</div></a>";
                        } else {
                            echo "<div class=\"tblB\">$name</div>";
                        }
                    }
                    echo "</div>";
                }
            }

            echo "<div class=\"booking-grid\">";
                       
            while ($k = mysqli_fetch_array($result)) {
                $name = $k['Room_name'];
                $Asize = $k['room_a_size'];
                $Csize = $k['room_c_size'];
                $category = $k['Category'];
                $photo = $k['photo'];
                $isB = $k['isbooked'];
                $id = $k['id'];
                $Dt = $datetime;

                if ($isB == 0) {
                    echo "<a href=\"../booking/room_booking.php?name=$name&dateTime=$Dt&Csize=$Csize&id=$id&Asize=$Asize\"><div class=\"tblN\">$name</div></a>";
                } else {
                    echo "<div class=\"tblB\">$name</div>";
                }
                
                echo "</div>";
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
