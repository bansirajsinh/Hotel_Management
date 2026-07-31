# 🏨 Booker — Hotel Management System

<p align="center">
  <strong>A complete hotel management & booking platform built with PHP and MySQL</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Apache-XAMPP-D42029?style=for-the-badge&logo=apache&logoColor=white" alt="Apache">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 📋 Table of Contents

- [About](#-about)
- [Features](#-features)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Installation & Setup](#-installation--setup)
- [Database Setup](#-database-setup)
- [Usage](#-usage)
- [Screenshots](#-screenshots)
- [Tech Stack](#-tech-stack)
- [Team](#-team)
- [Contributing](#-contributing)
- [License](#-license)

---

## 📖 About

**Booker** is a web-based hotel management system that enables hotel guests to browse and book various hotel services online. The application provides a seamless experience for booking rooms, restaurant tables, banquet halls, and transport services — all from a unified dashboard.

Built as an academic project at **GMIT (Gandhinagar Institute of Technology)**, the system demonstrates full-stack PHP development with MySQL database integration, cookie-based authentication, and responsive web design.

For detailed technical documentation, see [docs/PROJECT_DESCRIPTION.md](docs/PROJECT_DESCRIPTION.md).

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🔐 **User Auth** | Register, login, logout with cookie-based 30-day sessions |
| 🏨 **Room Booking** | Browse rooms by date/time, view capacity, one-click booking |
| 🍽️ **Table Booking** | Reserve restaurant tables across 12 available time slots |
| 🎪 **Banquet Booking** | Book event halls with AC/Non-AC, amenities & pricing info |
| 🚗 **Transport** | Browse fleet vehicles by company, capacity & pricing |
| 📬 **Contact Form** | Submit inquiries stored in the database |
| 📱 **Responsive** | Mobile-friendly with hamburger menu navigation |
| 🎨 **Color-Coded** | Green = Available, Red = Booked — at a glance |

---

## 📁 Project Structure

```
Hotel_Management/
│
├── config/                     # Configuration files
│   └── database.php            # Centralized DB connection
│
├── includes/                   # Reusable PHP components
│   ├── auth_check.php          # Authentication guard
│   ├── header.php              # Common HTML <head>
│   ├── navbar.php              # Navigation bar
│   └── footer.php              # Footer section
│
├── assets/                     # Static assets
│   ├── css/
│   │   ├── style.css           # Global styles
│   │   ├── navbar.css          # Navigation styles
│   │   ├── auth.css            # Login/Signup/Contact styles
│   │   └── booking.css         # Booking page styles
│   └── images/
│       ├── banquets/           # Banquet hall photos
│       ├── rooms/              # Room photos
│       ├── carousel/           # Hero slideshow images
│       ├── facilities/         # Restaurant, pool, parking, etc.
│       ├── people/             # People/testimonial images
│       └── general/            # Background, transport, etc.
│
├── pages/                      # Main application pages
│   ├── login.php               # User login
│   ├── signup.php              # User registration
│   ├── home.php                # Dashboard with carousel & booking grid
│   ├── about.php               # About us + contact form
│   ├── contact.php             # Contact us page
│   ├── rooms.php               # Room availability & listing
│   ├── tables.php              # Table availability & listing
│   ├── banquets.php            # Banquet availability & listing
│   └── transports.php          # Transport availability & listing
│
├── booking/                    # Booking confirmation pages
│   ├── room_booking.php        # Room booking details & confirm
│   ├── table_booking.php       # Table booking details & confirm
│   └── banquet_booking.php     # Banquet booking details & confirm
│
├── database/                   # Database files
│   └── schema.sql              # Complete DB schema setup script
│
├── docs/                       # Documentation
│   └── PROJECT_DESCRIPTION.md  # Detailed project description
│
├── index.php                   # Entry point (router)
├── .htaccess                   # Apache security config
├── .gitignore                  # Git ignore rules
└── README.md                   # This file
```

---

## 🔧 Prerequisites

Before you begin, ensure you have the following installed:

- **[XAMPP](https://www.apachefriends.org/)** (or WAMP/MAMP) — includes:
  - Apache Web Server
  - PHP 7.4 or higher
  - MySQL 5.7 or higher
  - phpMyAdmin
- **Web Browser** (Chrome, Firefox, Edge, etc.)
- **Git** (optional, for cloning)

---

## 🚀 Installation & Setup

### 1. Clone or Download

```bash
# Option A: Clone with Git
git clone https://github.com/your-username/Hotel_Management.git

# Option B: Download ZIP and extract to your XAMPP htdocs folder
```

### 2. Move to Web Server Directory

Copy the project folder to your XAMPP `htdocs` directory:

```
C:\xampp\htdocs\Hotel_Management\
```

### 3. Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** ✅
3. Start **MySQL** ✅

### 4. Set Up the Database

See the [Database Setup](#-database-setup) section below.

### 5. Configure Database Connection

Open `config/database.php` and update the credentials if needed:

```php
define('DB_HOST', 'localhost');   // Your MySQL host
define('DB_USER', 'root');       // Your MySQL username
define('DB_PASS', '');           // Your MySQL password
define('DB_NAME', 'booker');     // Database name
```

### 6. Access the Application

Open your browser and navigate to:

```
http://localhost/Hotel_Management/
```

---

## 🗄️ Database Setup

### Option A: Using phpMyAdmin (Recommended)

1. Open **phpMyAdmin** at `http://localhost/phpmyadmin/`
2. Click **"Import"** tab
3. Choose the file: `database/schema.sql`
4. Click **"Go"** to execute

### Option B: Using MySQL CLI

```bash
mysql -u root -p < database/schema.sql
```

### Database Overview

The `hotel_management` database contains **14 tables**:

| Category | Tables |
|----------|--------|
| **Users** | `user_db`, `contact_us` |
| **Rooms** | `rooms_db`, `room_check`, `room_book_request` |
| **Tables** | `tables`, `table_check`, `table_book_request` |
| **Banquets** | `benquet`, `benquet_check`, `benquet_book_request` |
| **Transport** | `transport`, `transport_check` |

---

## 📖 Usage

### User Flow

1. **Register** → Create an account at the signup page
2. **Login** → Authenticate with your email and password
3. **Browse** → View available rooms, tables, banquets, or transport
4. **Select Date/Time** → Check availability for your preferred slot
5. **Book** → Click on an available item (green) to view details
6. **Confirm** → Click "Book Now" to confirm your reservation

### Availability Color Codes

| Color | Status |
|-------|--------|
| 🟢 Green | Available — click to book |
| 🔴 Red | Already booked |

---

## 📸 Screenshots

> Add screenshots of your application here:
> 
> - Login Page
> - Home Dashboard
> - Room Booking Grid
> - Booking Confirmation

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| **Language** | PHP 7.4+ (Procedural) |
| **Database** | MySQL 5.7+ via MySQLi extension |
| **Frontend** | HTML5, CSS3 (Responsive) |
| **Web Server** | Apache (via XAMPP) |
| **Auth** | Cookie-based session management |
| **Architecture** | MVC-inspired (config/includes/pages separation) |

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

<p align="center">
  Made with ❤️ by Banirajsinh Gohil
</p>
