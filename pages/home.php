<?php
/**
 * Home Page
 * 
 * Main landing page after login. Displays the image carousel
 * and booking options (Tables, Rooms, Banquets, Transport).
 * 
 * @package Booker
 */

// Auth guard
require_once __DIR__ . '/../includes/auth_check.php';

$pageTitle = 'Booker - Home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
</head>
<body>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="all-e"> 
    <!-- Hero Slideshow -->
    <div class="slideshow-container">
        <div class="slide active">
            <img src="../assets/images/general/beach2.jpg" alt="Slide 1">
            <div class="slide-content">
                <h2>Welcome to Booker Hotel</h2>
                <p>Discover luxury accommodations at affordable prices.</p>
            </div>
        </div>
        <div class="slide">
            <img src="../assets/images/facilities/swimmingpool4_best.png" alt="Slide 2">
            <div class="slide-content">
                <h2>Experience Unforgettable Moments</h2>
                <p>Indulge in our world-class amenities and services.</p>
            </div>
        </div>
        <div class="slide">
            <img src="../assets/images/general/two.jpg" alt="Slide 3">
            <div class="slide-content">
                <h2>Book Your Stay Today</h2>
                <p>Enjoy a remarkable stay with exceptional hospitality.</p>
            </div>
        </div>
        
        <div class="slide-navigation">
            <span class="dot active" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <!-- Booking Options -->
    <div class="booking">
        <h3>Booking</h3>
    </div>
    <div class="grid-container">
        <a href="tables.php">
            <div class="grid-item hover-class">
                <img src="../assets/images/facilities/restuarent_tables.jpg" alt="Restaurant Tables" height="250px" width="250px">
                <h3>Tables</h3>
                <div class="overlay">
                    <p>Book Now</p>
                </div>
            </div>
        </a>
        <a href="rooms.php">
            <div class="grid-item hover-class">
                <img src="../assets/images/rooms/rooms.jpg" alt="Hotel Rooms" height="250px" width="250px">
                <h3>Rooms</h3>
                <div class="overlay">
                    <p>Book Now</p>
                </div>
            </div>
        </a>
        <a href="banquets.php">
            <div class="grid-item hover-class">
                <img src="../assets/images/banquets/BQ2.jpg" alt="Banquet Hall" height="250px" width="250px">
                <h3>Banquet</h3> 
                <div class="overlay">
                    <p>Book Now</p>
                </div>
            </div>
        </a>
        <a href="transports.php">
            <div class="grid-item hover-class">
                <img src="../assets/images/general/transport.jpg" alt="Transport Service" height="250px" width="250px">
                <h3>Transport</h3>
                <div class="overlay">
                    <p>Book Now</p>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Slideshow Script -->
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);
        
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        
        function showSlides(n) {
            const slides = document.getElementsByClassName("slide");
            const dots = document.getElementsByClassName("dot");
            
            if (n > slides.length) {
                slideIndex = 1;
            }
            
            if (n < 1) {
                slideIndex = slides.length;
            }
            
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            
            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }
            
            slides[slideIndex - 1].classList.add("active");
            dots[slideIndex - 1].classList.add("active");

            setTimeout(() => {
                showSlides(slideIndex += 1);
            }, 4000);
        }

        function toggleMenu() {
            const menu = document.querySelector(".nav ul");
            menu.classList.toggle("active");
        }
    </script>
</div>
</body>
</html>
