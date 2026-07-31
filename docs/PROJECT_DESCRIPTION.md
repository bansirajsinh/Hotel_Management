# Booker — Hotel Management System

## Project Description

**Booker** is a full-featured hotel management and booking web application built with PHP and MySQL. It provides an intuitive online platform for hotel guests to browse and book various hotel services including rooms, restaurant tables, banquet halls, and transport services.

This project was developed as an academic project by three students from **GMIT (Gandhinagar Institute of Technology)**.

---

## Team Members

| Name | Role |
|------|------|
| **Kotecha Priyansh** | Frontend Design & UI Development |
| **Trivedi Aayush** | Frontend Design & Table Booking Module |
| **Gohil Bansirajsinh** | Backend Development & Database Management |

---

## Features

### 🔐 User Authentication
- **Registration**: New users can create an account with username, email, and password
- **Login/Logout**: Cookie-based session management with 30-day persistence
- **Auth Guards**: All booking pages are protected and redirect unauthenticated users to login

### 🏨 Room Booking
- Browse available rooms by date and time
- View room details (name, adult capacity, child capacity, category)
- Real-time availability: Green = Available, Red = Booked
- One-click booking with automatic status update

### 🍽️ Table Booking
- Reserve restaurant tables with flexible time slots (10:00 AM - 11:00 PM)
- View table size/capacity before booking
- Color-coded availability grid

### 🎪 Banquet Hall Booking
- Book banquet halls for events and functions
- View hall details: size, AC/Non-AC, included amenities, pricing, photos
- Date-based availability checking

### 🚗 Transport Services
- Browse available transport services by date/time
- View company name, car details, pricing, and capacity
- Multi-vehicle fleet management

### 📬 Contact Us
- Contact form for visitor inquiries
- Messages stored in the database for review

---

## Technology Stack

| Layer | Technology |
|-------|------------|
| **Frontend** | HTML5, CSS3 (Responsive Design) |
| **Backend** | PHP 7+ (Procedural) |
| **Database** | MySQL via MySQLi |
| **Server** | Apache (XAMPP / WAMP / MAMP) |
| **Authentication** | Cookie-based sessions |

---

## Database Design

The application uses a MySQL database named `booker` with **14 tables**:

### Core Tables
- `user_db` — Registered users (name, email, password, login tracking)
- `contact_us` — Contact form submissions

### Room Management
- `rooms_db` — Master list of all rooms
- `room_check` — Date/time-specific room availability
- `room_book_request` — Confirmed room bookings

### Table Management
- `tables` — Master list of restaurant tables
- `table_check` — Date/time-specific table availability
- `table_book_request` — Confirmed table bookings

### Banquet Management
- `benquet` — Master list of banquet halls
- `benquet_check` — Date-specific banquet availability
- `benquet_book_request` — Confirmed banquet bookings

### Transport Management
- `transport` — Master fleet of available vehicles
- `transport_check` — Date/time-specific transport availability

---

## Architecture Notes

- **Availability System**: When a user queries availability for a new date/time, the system copies master records into `*_check` tables with `isBooked=0`. Subsequent bookings toggle `isBooked` to `1`.
- **Authentication**: Uses PHP cookies (`user`, `email`, `password`) with 30-day expiry.
- **Booking Flow**: List page → Select available item → Confirmation page → Book → Database update.

---
