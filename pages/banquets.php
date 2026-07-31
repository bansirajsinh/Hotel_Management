<?php
/**
 * Banquets Listing Page
 * 
 * Displays available banquet halls for a selected date.
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
    <title>Booker - Book Banquets</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
</head>
<body> 
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <form method="post">
        <input type="date" name="date"> <br>
        <input type="submit" value="Submit" name="Submit">
    </form>

    <?php 
        if (isset($_POST['Submit'])) {
            extract($_POST);

            $conn = getDBConnection();
            $flg = 1;

            $query = "SELECT * FROM `benquet_check` WHERE `date`='$date'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query2 = "SELECT * FROM `benquet`";
                $result2 = mysqli_query($conn, $query2);

                while ($i = mysqli_fetch_array($result2)) {
                    $name = $i['name'];
                    $size = $i['Benquet_size'];
                    $ac_no = $i['ac-no'];
                    $include = $i['Benquet_include'];
                    $Description = $i['description'];
                    $price = $i['price'];
                    $photo = $i['photo'];
                    $isB = 0;
                    $id = $i['id'];
                    $Dt = $date;

                    $query3 = "INSERT INTO `benquet_check` (`id`, `name`, `Benquet_size`, `ac-no`, `Benquet_include`, `price`, `photo`, `date`, `isBooked`) VALUES (NULL, '$name', '$size', '$ac_no', '$include', '$price', '$photo', '$Dt', '$isB')"; 
                    $result3 = mysqli_query($conn, $query3);
                    if ($result3) {
                        $flg = 1;
                    }
                }

                if ($flg == 1) {
                    $query4 = "SELECT * FROM `benquet_check` WHERE `date`='$date'";
                    $result4 = mysqli_query($conn, $query4);

                    echo "<div class=\"booking-grid\">";
                   
                    while ($j = mysqli_fetch_array($result4)) {
                        $name = $j['name'];
                        $size = $j['Benquet_size'];
                        $ac_no = $j['ac-no'];
                        $include = $j['Benquet_include'];
                        $id = $j['id'];
                        $price = $j['price'];
                        $photo = $j['photo'];
                        $isB = $j['isBooked'];
                        $Dt = $date;

                        if ($isB == 0) {
                            echo "<a href=\"../booking/banquet_booking.php?name=$name&dateTime=$Dt&size=$size&id=$id&ac_no=$ac_no&photo=$photo&include=$include&price=$price\"><div class=\"tblN\">$name</div></a>";
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
                $size = $k['Benquet_size'];
                $ac_no = $k['ac-no'];
                $include = $k['Benquet_include'];
                $price = $k['price'];
                $id = $k['id'];
                $photo = $k['photo'];
                $isB = $k['isBooked'];
                $Dt = $date;

                if ($isB == 0) {
                    echo "<a href=\"../booking/banquet_booking.php?name=$name&dateTime=$Dt&size=$size&id=$id&ac_no=$ac_no&photo=$photo&include=$include&price=$price\"><div class=\"tblN\">$name</div></a>";
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
