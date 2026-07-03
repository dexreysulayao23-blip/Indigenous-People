<?php 
include_once 'connection.php';

try{
  // Get form data
  $check_username = isset($_POST['check_username']) ? trim($_POST['check_username']) : '';
  $check_number = isset($_POST['check_number']) ? trim($_POST['check_number']) : '';
  $contact_number = isset($_POST['contact_number']) ? trim($_POST['contact_number']) : '';
  $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
  $new_confirm_password = isset($_POST['new_confirm_password']) ? trim($_POST['new_confirm_password']) : '';

  // Check if required fields are empty
  if(empty($check_username) || empty($check_number) || empty($contact_number) || empty($new_password) || empty($new_confirm_password)){
    echo 'error7'; // EMPTY REQUIRED FIELDS
    exit;
  }

  // Check if user exists
  $sql_user = "SELECT * FROM `users` WHERE (username = ? OR id = ?)";
  $stmt_user = $con->prepare($sql_user);
  if(!$stmt_user){
    echo 'error4'; // DATABASE UPDATE FAILED
    exit;
  }
  $stmt_user->bind_param('ss', $check_username, $check_username);
  $stmt_user->execute();
  $result_user = $stmt_user->get_result();
  
  if($result_user->num_rows == 0){
    $stmt_user->close();
    echo 'error5'; // USER NOT FOUND
    exit;
  }

  $row_user = $result_user->fetch_assoc();
  $user_id = trim($row_user['id']);
  
  // Get civil status and family_number from residence_information
  $sql_residence = "SELECT civil_status, family_number FROM `residence_information` WHERE residence_id = ?";
  $stmt_residence = $con->prepare($sql_residence);
  $contact_number_to_verify = '';
  
  if($stmt_residence){
    $stmt_residence->bind_param('s', $user_id);
    $stmt_residence->execute();
    $result_residence = $stmt_residence->get_result();
    
    if($result_residence->num_rows > 0){
      $row_residence = $result_residence->fetch_assoc();
      $civil_status = isset($row_residence['civil_status']) ? $row_residence['civil_status'] : '';
      
      // If married, widowed, separated, or annulled/divorced, use family_number
      // Otherwise, use contact_number (for Single or if civil_status is not set)
      if($civil_status == 'Married' || $civil_status == 'Widowed' || $civil_status == 'Separated' || $civil_status == 'Annulled / Divorced'){
        $contact_number_to_verify = isset($row_residence['family_number']) && !empty($row_residence['family_number']) ? $row_residence['family_number'] : $row_user['contact_number'];
      } else {
        // For Single or if civil_status is not set, use contact_number
        $contact_number_to_verify = $row_user['contact_number'];
      }
    } else {
      // If no residence_information found, use contact_number from users table
      $contact_number_to_verify = $row_user['contact_number'];
    }
    $stmt_residence->close();
  } else {
    // If query fails, use contact_number from users table
    $contact_number_to_verify = $row_user['contact_number'];
  }
  
  // Verify last 4 digits of contact number
  if(empty($contact_number_to_verify) || strlen($contact_number_to_verify) < 4){
    $stmt_user->close();
    echo 'error'; // 4 DIGIT NOT MATCH - Invalid contact number
    exit;
  }
  
  $last_4_digits = substr($contact_number_to_verify, -4);
  
  if($contact_number !== $last_4_digits){
    $stmt_user->close();
    echo 'error'; // 4 DIGIT NOT MATCH
    exit;
  }

  // Check if passwords match
  if($new_password !== $new_confirm_password){
    $stmt_user->close();
    echo 'error1'; // PASSWORD NOT MATCH
    exit;
  }

  // Check password length
  if(strlen($new_password) < 8){
    $stmt_user->close();
    echo 'error2'; // PASSWORD TOO SHORT
    exit;
  }

  // Update password using user ID (more reliable than username)
  $sql_update = "UPDATE `users` SET `password` = ? WHERE `id` = ?";
  $stmt_update = $con->prepare($sql_update);
  
  if(!$stmt_update){
    $stmt_user->close();
    echo 'error4'; // DATABASE UPDATE FAILED - Prepare error
    exit;
  }
  
  $stmt_update->bind_param('ss', $new_password, $user_id);
  
  if(!$stmt_update->execute()){
    $error_msg = $stmt_update->error;
    $stmt_update->close();
    $stmt_user->close();
    echo 'error4'; // DATABASE UPDATE FAILED - Execute error
    exit;
  }

  // Close statements
  $stmt_update->close();
  $stmt_user->close();
  
  // Verify the password was actually updated
  $sql_verify = "SELECT password FROM `users` WHERE `id` = ?";
  $stmt_verify = $con->prepare($sql_verify);
  if($stmt_verify){
    $stmt_verify->bind_param('s', $user_id);
    $stmt_verify->execute();
    $result_verify = $stmt_verify->get_result();
    $row_verify = $result_verify->fetch_assoc();
    $stmt_verify->close();
    
    if($row_verify && $row_verify['password'] === $new_password){
      echo 'success';
      exit;
    }
  }
  
  // If verification failed, return error
  echo 'error4'; // DATABASE UPDATE FAILED - Password not updated
  exit;

}catch(Exception $e){
  echo 'error4'; // DATABASE UPDATE FAILED
  exit;
}

