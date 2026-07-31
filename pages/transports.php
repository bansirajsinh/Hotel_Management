<?php
/**
 * Transports Listing Page
 * 
 * Displays available transport services for a selected date/time.
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
    <title>Booker - Book Transports</title>
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

            $query = "SELECT * FROM `transport_check` WHERE `datetime`='$datetime'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query2 = "SELECT * FROM `transport`";
                $result2 = mysqli_query($conn, $query2);

                while ($i = mysqli_fetch_array($result2)) {
                    $Comapanyname = $i['CompanyName'];
                    $Carname = $i['CarName'];
                    $CarSize = $i['CarSize'];
                    $CarPrice = $i['CarPrice'];
                    $description = $i['description'];
                    $photo = $i['photo'];
                    $isB = 0;
                    $Dt = $datetime;

                    $query3 = "INSERT INTO `transport_check` (`id`, `CompanyName`, `CarName`, `isBooked`, `CarPrice`, `CarSize`, `description`, `photo`,`datetime`) VALUES (NULL, '$Comapanyname', '$Carname', '$isB', '$CarPrice', '$CarSize', '$description', '$photo','$Dt')"; 
                    $result3 = mysqli_query($conn, $query3);
                    if ($result3) {
                        $flg = 1;
                    }
                }

                if ($flg == 1) {
                    $query4 = "SELECT * FROM `transport_check` WHERE `datetime`='$datetime'";
                    $result4 = mysqli_query($conn, $query4);

                    while ($j = mysqli_fetch_array($result4)) {
                        $CompanyName = $j['CompanyName'];
                        $Carname = $j['CarName'];
                        $CarSize = $j['CarSize'];
                        $CarPrice = $j['CarPrice'];
                        $description = $j['description'];
                        $photo = $j['photo'];
                        $isB = $j['isBooked'];
                        $Dt = $j['datetime'];

                        echo "Company :: $CompanyName, $Carname";
                    }
                }
            }
            
            while ($k = mysqli_fetch_array($result)) {
                $CompanyName = $k['CompanyName'];
                $Carname = $k['CarName'];
                $CarSize = $k['CarSize'];
                $CarPrice = $k['CarPrice'];
                $description = $k['description'];
                $photo = $k['photo'];
                $isB = $k['isBooked'];
                $Dt = $k['datetime'];

                echo "Company :: $CompanyName, $Carname";
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
