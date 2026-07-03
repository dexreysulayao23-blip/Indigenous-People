<?php 
/**
 * Script to create spouse and children tables if they don't exist
 * Run this file once to create the missing tables
 */

include_once 'connection.php';

echo "Checking and creating spouse and children tables...\n\n";

try {
    // Create spouse table
    $check_spouse = $con->query("SHOW TABLES LIKE 'spouse'");
    if($check_spouse->num_rows == 0){
        echo "Creating spouse table...\n";
        $create_spouse_sql = "CREATE TABLE `spouse` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `residence_id` varchar(255) NOT NULL,
            `name` varchar(255) DEFAULT NULL,
            `sex` varchar(10) DEFAULT NULL,
            `age` varchar(10) DEFAULT NULL,
            `birthday` date DEFAULT NULL,
            `ip_group` varchar(255) DEFAULT NULL,
            `place_of_origin` varchar(255) DEFAULT NULL,
            `registered_voter` varchar(10) DEFAULT NULL,
            `civil_status` varchar(50) DEFAULT NULL,
            `registered_civil_registry` varchar(10) DEFAULT NULL,
            `birth_registration` varchar(10) DEFAULT NULL,
            `marriage_registration` varchar(10) DEFAULT NULL,
            `beneficiary` text DEFAULT NULL,
            `beneficiary_others` varchar(255) DEFAULT NULL,
            `vaccinated_against` varchar(255) DEFAULT NULL,
            `pwd` varchar(10) DEFAULT NULL,
            `pwd_info` varchar(255) DEFAULT NULL,
            `senior_citizen` varchar(10) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `residence_id` (`residence_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        
        if($con->query($create_spouse_sql)){
            echo "✓ Spouse table created successfully!\n";
        } else {
            echo "✗ Error creating spouse table: " . $con->error . "\n";
        }
    } else {
        echo "✓ Spouse table already exists.\n";
    }
    
    // Create children table
    $check_children = $con->query("SHOW TABLES LIKE 'children'");
    if($check_children->num_rows == 0){
        echo "\nCreating children table...\n";
        $create_children_sql = "CREATE TABLE `children` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `residence_id` varchar(255) NOT NULL,
            `first_name` varchar(255) DEFAULT NULL,
            `middle_name` varchar(255) DEFAULT NULL,
            `last_name` varchar(255) DEFAULT NULL,
            `civil_status` varchar(50) DEFAULT NULL,
            `birthday` date DEFAULT NULL,
            `age` varchar(10) DEFAULT NULL,
            `birthday_registered` varchar(10) DEFAULT NULL,
            `sex` varchar(10) DEFAULT NULL,
            `religion` varchar(255) DEFAULT NULL,
            `phic` varchar(10) DEFAULT NULL,
            `4ps` varchar(10) DEFAULT NULL,
            `pensioner` varchar(10) DEFAULT NULL,
            `registered_voter` varchar(10) DEFAULT NULL,
            `pwd` varchar(10) DEFAULT NULL,
            `pwd_info` varchar(255) DEFAULT NULL,
            `senior_citizen` varchar(10) DEFAULT NULL,
            `has_children` varchar(10) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `residence_id` (`residence_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        
        if($con->query($create_children_sql)){
            echo "✓ Children table created successfully!\n";
        } else {
            echo "✗ Error creating children table: " . $con->error . "\n";
        }
    } else {
        echo "✓ Children table already exists.\n";
    }
    
    // Check and add missing columns to children table
    echo "\nChecking children table columns...\n";
    $check_age = $con->query("SHOW COLUMNS FROM children LIKE 'age'");
    if($check_age->num_rows == 0){
        $con->query("ALTER TABLE children ADD COLUMN `age` varchar(10) DEFAULT NULL AFTER `birthday`");
        echo "✓ Added 'age' column to children table.\n";
    }
    
    // Check and add missing columns to spouse table
    echo "\nChecking spouse table columns...\n";
    $check_spouse_pwd = $con->query("SHOW COLUMNS FROM spouse LIKE 'pwd'");
    if($check_spouse_pwd->num_rows == 0){
        $con->query("ALTER TABLE spouse ADD COLUMN `pwd` varchar(10) DEFAULT NULL AFTER `vaccinated_against`");
        echo "✓ Added 'pwd' column to spouse table.\n";
    }
    
    $check_spouse_pwd_info = $con->query("SHOW COLUMNS FROM spouse LIKE 'pwd_info'");
    if($check_spouse_pwd_info->num_rows == 0){
        $con->query("ALTER TABLE spouse ADD COLUMN `pwd_info` varchar(255) DEFAULT NULL AFTER `pwd`");
        echo "✓ Added 'pwd_info' column to spouse table.\n";
    }
    
    $check_spouse_senior = $con->query("SHOW COLUMNS FROM spouse LIKE 'senior_citizen'");
    if($check_spouse_senior->num_rows == 0){
        $con->query("ALTER TABLE spouse ADD COLUMN `senior_citizen` varchar(10) DEFAULT NULL AFTER `pwd_info`");
        echo "✓ Added 'senior_citizen' column to spouse table.\n";
    }
    
    echo "\n\n=== Summary ===\n";
    echo "All tables and columns have been checked and created if needed.\n";
    echo "You can now use the spouse and children features in your system.\n";
    
} catch(Exception $e){
    echo "Error: " . $e->getMessage() . "\n";
}

$con->close();
?>

