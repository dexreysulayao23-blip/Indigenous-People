<?php 
include_once 'connection.php';

try{
  if(isset($_POST['username'])){
    $username = $con->real_escape_string($_POST['username']);
    
    // Check in registration_requests table
    $sql = "SELECT * FROM registration_requests WHERE username = ?";
    $stmt = $con->prepare($sql) or die ($con->error);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      echo json_encode([
        'status' => 'found',
        'request_status' => $row['status'],
        'request_id' => $row['request_id'],
        'date_requested' => date('F d, Y h:i A', strtotime($row['date_requested'])),
        'date_processed' => $row['date_processed'] ? date('F d, Y h:i A', strtotime($row['date_processed'])) : '',
        'admin_notes' => $row['admin_notes']
      ]);
    } else {
      // Check if already approved and in users table
      $sql_user = "SELECT * FROM users WHERE username = ? AND user_type = 'resident'";
      $stmt_user = $con->prepare($sql_user) or die ($con->error);
      $stmt_user->bind_param('s', $username);
      $stmt_user->execute();
      $result_user = $stmt_user->get_result();
      
      if($result_user->num_rows > 0){
        echo json_encode([
          'status' => 'found',
          'request_status' => 'approved',
          'message' => 'Your account is active. You can login now.'
        ]);
      } else {
        echo json_encode([
          'status' => 'not_found',
          'message' => 'No registration request found for this username.'
        ]);
      }
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Username is required']);
  }
}catch(Exception $e){
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>

