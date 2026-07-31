<?php
/**
 * Database Configuration
 * 
 * Centralized database connection settings for the Booker
 * Hotel Management System. All PHP files should include
 * this file instead of defining connection variables inline.
 * 
 * @package Booker
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'booker');

/**
 * Get a MySQLi database connection.
 *
 * @return mysqli|false  Returns a mysqli object on success or false on failure.
 */
function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Set charset to avoid encoding issues
    mysqli_set_charset($conn, "utf8");

    return $conn;
}
?>
