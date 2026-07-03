 (#667eea to #764ba2)<?php
include_once 'connection.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Get only active certificate types
    $sql = "SELECT certificate_type_id, certificate_name, description, fee, validity_days FROM certificate_types WHERE is_active = 1 ORDER BY certificate_name ASC";
    $query = $con->query($sql);
    
    $certificates = [];
    if($query && $query->num_rows > 0) {
        while($row = $query->fetch_assoc()) {
            $certificates[] = [
                'id' => $row['certificate_type_id'],
                'name' => $row['certificate_name'],
                'description' => $row['description'],
                'fee' => $row['fee'],
                'validity_days' => $row['validity_days']
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'certificates' => $certificates
    ]);
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
