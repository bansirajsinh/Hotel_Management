<?php
/**
 * Database Configuration
 * 
 * Centralized database connection settings for the 
 * Hotel Management System. All PHP files should include
 * this file instead of defining connection variables inline.
 * 
 * @package HotelManagement
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hotel_management');

// Enable MySQLi exceptions for centralized error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Get a MySQLi database connection.
 *
 * @return mysqli  Returns a mysqli object on success.
 * @throws Exception If connection fails.
 */
function getDBConnection() {
    try {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Set charset to avoid encoding issues
        mysqli_set_charset($conn, "utf8mb4");
        
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // In a production environment, you would log this error and show a generic message.
        // For development, we might show the message or a sanitized version.
        error_log("Database connection failed: " . $e->getMessage());
        die("A database error occurred. Please try again later.");
    }
}
?>
