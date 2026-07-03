<?php 

// =====================================================
// DATABASE CONNECTION CONFIGURATION
// =====================================================
// Switch between LOCALHOST and INFINITYFREE by changing the HOSTING_MODE below
// Options: 'localhost' or 'infinityfree'

define("HOSTING_MODE", 'localhost'); // Change to 'localhost' for local development

// =====================================================
// LOCALHOST CONFIGURATION (XAMPP)
// =====================================================
if (HOSTING_MODE == 'localhost') {
    define("DB_USER", 'root');
    define("DB_PASSWORD", ''); // Default XAMPP: empty password
    define("DB_NAME", 'ipsdb');
    define("DB_HOST", 'localhost');
    define("DB_PORT", '3306'); // Optional: MySQL port
}
// =====================================================
// INFINITYFREE CONFIGURATION
// =====================================================
else if (HOSTING_MODE == 'infinityfree') {
    // IMPORTANT: Update these values with your InfinityFree database credentials
    // You can find these in your InfinityFree control panel > MySQL Databases
    
    // Database Host (usually sqlXXX.infinityfree.com)
    define("DB_HOST", 'sql100.infinityfree.com'); // Updated with your server
    
    // Database Username (usually if0_XXXXXX)
    define("DB_USER", 'if0_40534050'); // Updated with your username
    
    // Database Password (from InfinityFree control panel)
    define("DB_PASSWORD", 'Sulayao1998'); // Database password from InfinityFree
    
    // Database Name (usually if0_XXXXXX_ipsdb)
    define("DB_NAME", 'if0_40534050_if0_40534050_ipsdb'); // Updated with your database name
    
    // InfinityFree usually doesn't require a port, but if needed, use 3306
    define("DB_PORT", '3306');
}

// =====================================================
// CREATE DATABASE CONNECTION
// =====================================================
try {
    // Use port if defined
    if (defined('DB_PORT') && DB_PORT) {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    } else {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    // Set charset to utf8mb4 for proper Unicode support
    $con->set_charset("utf8mb4");
    
    // Enable foreign key checks
    $con->query("SET FOREIGN_KEY_CHECKS = 1");
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

?>
