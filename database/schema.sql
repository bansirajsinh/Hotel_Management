-- ============================================
-- Hotel Management System
-- Database Schema
-- ============================================
-- 
-- Database: `hotel_management`
-- Run this script in phpMyAdmin or MySQL CLI
-- to set up the required tables.
--

CREATE DATABASE IF NOT EXISTS `hotel_management`;
USE `hotel_management`;

-- ============================================
-- Users Table
-- ============================================
CREATE TABLE IF NOT EXISTS `user_db` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `datetime` DATETIME NOT NULL,
    `Last_Login` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Rooms Master Table
-- ============================================
CREATE TABLE IF NOT EXISTS `rooms_db` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Room_name` VARCHAR(100) NOT NULL,
    `room_a_size` INT(11) NOT NULL,
    `room_c_size` INT(11) NOT NULL,
    `room_description` TEXT DEFAULT NULL,
    `Category` VARCHAR(50) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Room Availability Check Table
-- ============================================
CREATE TABLE IF NOT EXISTS `room_check` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Room_name` VARCHAR(100) NOT NULL,
    `is_booked` TINYINT(1) NOT NULL DEFAULT 0,
    `date_time` VARCHAR(50) NOT NULL,
    `room_a_size` INT(11) NOT NULL,
    `room_c_size` INT(11) NOT NULL,
    `Category` VARCHAR(50) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_room_availability` (`date_time`, `is_booked`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Room Booking Requests
-- ============================================
CREATE TABLE IF NOT EXISTS `room_book_request` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Person_name` VARCHAR(100) NOT NULL,
    `Person_email` VARCHAR(150) NOT NULL,
    `datetime` VARCHAR(50) NOT NULL,
    `Room_name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Tables Master Table
-- ============================================
CREATE TABLE IF NOT EXISTS `tables` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Table_name` VARCHAR(100) NOT NULL,
    `Table_size` INT(11) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table Availability Check Table
-- ============================================
CREATE TABLE IF NOT EXISTS `table_check` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `is_booked` TINYINT(1) NOT NULL DEFAULT 0,
    `date_time` VARCHAR(50) NOT NULL,
    `size` INT(11) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_table_availability` (`date_time`, `is_booked`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table Booking Requests
-- ============================================
CREATE TABLE IF NOT EXISTS `table_book_request` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Person_name` VARCHAR(100) NOT NULL,
    `Person_email` VARCHAR(150) NOT NULL,
    `datetime` VARCHAR(50) NOT NULL,
    `Table_name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Banquet Master Table (Renamed from benquet)
-- ============================================
CREATE TABLE IF NOT EXISTS `banquet` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `Banquet_size` INT(11) NOT NULL,
    `ac-no` VARCHAR(20) DEFAULT NULL,
    `Banquet_include` TEXT DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Banquet Availability Check Table (Renamed)
-- ============================================
CREATE TABLE IF NOT EXISTS `banquet_check` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `Banquet_size` INT(11) NOT NULL,
    `ac-no` VARCHAR(20) DEFAULT NULL,
    `Banquet_include` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `date` VARCHAR(50) NOT NULL,
    `is_booked` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_banquet_availability` (`date`, `is_booked`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Banquet Booking Requests (Renamed)
-- ============================================
CREATE TABLE IF NOT EXISTS `banquet_book_request` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `Person_name` VARCHAR(100) NOT NULL,
    `Person_email` VARCHAR(150) NOT NULL,
    `datetime` VARCHAR(50) NOT NULL,
    `banquet_name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Transport Master Table
-- ============================================
CREATE TABLE IF NOT EXISTS `transport` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `CompanyName` VARCHAR(100) NOT NULL,
    `CarName` VARCHAR(100) NOT NULL,
    `CarSize` INT(11) NOT NULL,
    `CarPrice` DECIMAL(10,2) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Transport Availability Check Table
-- ============================================
CREATE TABLE IF NOT EXISTS `transport_check` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `CompanyName` VARCHAR(100) NOT NULL,
    `CarName` VARCHAR(100) NOT NULL,
    `is_booked` TINYINT(1) NOT NULL DEFAULT 0,
    `CarPrice` DECIMAL(10,2) NOT NULL,
    `CarSize` INT(11) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `datetime` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_transport_availability` (`datetime`, `is_booked`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Contact Us Messages
-- ============================================
CREATE TABLE IF NOT EXISTS `contact_us` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
