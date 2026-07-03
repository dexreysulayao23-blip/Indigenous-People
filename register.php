

<?php
//index.php
include_once 'connection.php';
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_type']){


  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE id = '$user_id'";
  $query = $con->query($sql) or die ($con->error);
  $row = $query->fetch_assoc();
  $account_type = $row['user_type'];
  if ($account_type == 'admin') {
      echo '<script>
          window.location.href="admin/dashboard.php";
      </script>';
  } else {
      echo '<script>
          window.location.href="resident/dashboard.php";
      </script>';
  
}
}

$sql = "SELECT * FROM `IPs_information`";
  $query = $con->prepare($sql) or die ($con->error);
  $query->execute();
  $result = $query->get_result();
  
  // Initialize default values
  $IPs = 'IPs';
  $zone = 'Zone';
  $district = 'District';
  $image = 'default.png';
  $image_path = '../assets/dist/img/default.png';
  $id = '1';
  $postal_address = 'Postal Address';
  $background_image_path = 'assets/logo/cover.jpg';
  
  while($row = $result->fetch_assoc()){
      $IPs = $row['IPs'];
      $zone = $row['zone'];
      $district = $row['district'];
      $image = $row['image'];
      $image_path = $row['image_path'];
      $id = $row['id'];
      $postal_address = $row['postal_address'];
      // Get background image, default to cover.jpg if not set - SAME LOGIC AS admin/settings.php
      $background_image = isset($row['background_image']) ? trim($row['background_image']) : '';
      $background_image_path = isset($row['background_image_path']) && !empty(trim($row['background_image_path'])) ? trim($row['background_image_path']) : '../assets/logo/cover.jpg';
      
      // Remove '../' prefix for public pages (for display)
      $background_image_path_display = str_replace('../', '', $background_image_path);
      
      // Get absolute path for file checking (same as admin/settings.php)
      $script_dir = dirname(__FILE__);
      $base_dir = $script_dir; // register.php is in root, so no need to go up
      
      // Verify background image file exists - SAME LOGIC AS admin/settings.php
      if(!empty($background_image_path) && $background_image_path != '../assets/logo/cover.jpg'){
        $bg_check = str_replace('../', $base_dir . '/', $background_image_path);
        if(!file_exists($bg_check)){
          // File doesn't exist, use default
          $background_image = '';
          $background_image_path = '../assets/logo/cover.jpg';
          $background_image_path_display = 'assets/logo/cover.jpg';
        } else {
          // File exists, use it
          $background_image_path_display = str_replace('../', '', $background_image_path);
        }
      } else {
        // Use default
        $background_image_path_display = 'assets/logo/cover.jpg';
      }
      
      // If we have a background_image name, prioritize it (same as admin/settings.php)
      if (!empty($background_image) && $background_image != '') {
          $constructed_path = 'assets/logo/' . $background_image;
          $constructed_check = $base_dir . '/' . $constructed_path;
          if (file_exists($constructed_check)) {
              $background_image_path_display = $constructed_path;
          }
      }
  }

 

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPs Portal - Registration</title>
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <link rel="stylesheet" href="assets/plugins/sweetalert2/css/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/plugins/step-wizard/css/smart_wizard_all.min.css">

  <style>
    /* Wife/Husband section now shows even for Single (optional) */
    /* Commented out - section should be visible for Single but optional
    body.civil-status-single #wife_husband_section,
    body.civil-status-single #wife_husband_section * {
      display: none !important;
      visibility: hidden !important;
      height: 0 !important;
      overflow: hidden !important;
      opacity: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    */
    */
    
    /* Specifically hide all spouse-related fields when Single */
    body.civil-status-single #add_spouse_registered_civil_registry,
    body.civil-status-single #add_spouse_pwd,
    body.civil-status-single #add_spouse_registered_voter,
    body.civil-status-single #add_spouse_senior,
    body.civil-status-single #add_spouse_vaccinated_against,
    body.civil-status-single #spouse_beneficiary_philhealth,
    body.civil-status-single #spouse_beneficiary_sss,
    body.civil-status-single #spouse_beneficiary_gsis,
    body.civil-status-single #spouse_beneficiary_4ps,
    body.civil-status-single #spouse_beneficiary_senior,
    body.civil-status-single #spouse_beneficiary_pwd,
    body.civil-status-single #spouse_beneficiary_others,
    body.civil-status-single #add_spouse_beneficiary_others,
    body.civil-status-single label[for="add_spouse_pwd"],
    body.civil-status-single label[for="add_spouse_registered_voter"],
    body.civil-status-single label[for="add_spouse_senior"] {
      display: none !important;
      visibility: hidden !important;
    }
    
    .rightBar:hover{
      border-bottom: 3px solid red;
     
    }
    


    
    #IPs_logo{
      height: 150px;
      width:auto;
      max-width:500px;
    }

    .logo{
      height: 150px;
      width:auto;
      max-width:500px;
    }
    .double {
  background-color:  rgba(0,54,175,.75);
  <?php 
  // Use the display path (already verified to exist)
  if (!empty($background_image_path_display)) {
    echo "background-image: url('" . $background_image_path_display . "');";
  } else {
    echo "background-image: url('assets/logo/cover.jpg');";
  }
  ?>
   background-repeat: no-repeat;
      background-size: cover;
      width: 100%;
        height: 100%;
        animation-name: example;
        animation-duration: 5s;
}

   



@keyframes example {
  from {opacity: 0;}
  to {opacity: 1.5;}
}






    /* Indigenous People Theme */
    body {
      background: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #CD853F 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px);
      margin: 20px auto;
      max-width: 1200px;
      overflow: hidden;
    }

    .header-section {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2691E 100%);
      color: white;
      padding: 30px;
      text-align: center;
      position: relative;
    }

    .header-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('assets/logo/cover.jpg') center/cover;
      opacity: 0.1;
      z-index: 0;
    }

    .header-content {
      position: relative;
      z-index: 1;
    }

    .logo-section {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .logo-section img {
      height: 80px;
      width: 80px;
      border-radius: 50%;
      margin-right: 20px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 20px rgba(139, 69, 19, 0.5);
    }

    .logo-section h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .form-container {
      padding: 40px;
    }

    .profile-section {
      background: linear-gradient(135deg, #F5DEB3 0%, #DEB887 100%);
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      margin-bottom: 30px;
      border: 3px solid #8B4513;
      box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
    }

    .profile-image {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #8B4513;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
      box-shadow: 0 0 20px rgba(139, 69, 19, 0.3);
    }

    .profile-image:hover {
      transform: scale(1.05);
      border-color: #A0522D;
      box-shadow: 0 0 30px rgba(139, 69, 19, 0.5);
    }

    /* Keep Senior Citizen checkbox blue when disabled and checked */
    .senior-checkbox:checked {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e") !important;
    }
    
    .senior-checkbox:checked:disabled {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e") !important;
    }
    
    #add_senior.senior-checked:checked,
    #add_spouse_senior.senior-checked:checked,
    #add_senior:checked:disabled,
    #add_spouse_senior:checked:disabled {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
      cursor: not-allowed !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e") !important;
    }
    
    #add_senior.senior-checked,
    #add_spouse_senior.senior-checked {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
    }
    
    #add_senior:disabled,
    #add_spouse_senior:disabled {
      opacity: 1 !important;
    }
    
    .form-check-input:checked[disabled] {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
    }
    
    #add_senior.form-check-input:checked[disabled],
    #add_spouse_senior.form-check-input:checked[disabled] {
      background-color: #007bff !important;
      border-color: #007bff !important;
      opacity: 1 !important;
    }
    
    /* Additional override for Bootstrap's disabled checkbox styling */
    input[type="checkbox"].form-check-input:checked:disabled#add_senior,
    input[type="checkbox"].form-check-input:checked:disabled#add_spouse_senior,
    input[type="checkbox"].senior-checkbox:checked:disabled {
      background-color: #007bff !important;
      border-color: #007bff !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e") !important;
    }
    
    /* Ensure all checkboxes have consistent blue color when checked */
    #add_voters:checked,
    #add_pwd:checked,
    #add_senior:checked,
    #add_spouse_pwd:checked,
    #add_spouse_senior:checked {
      background-color: #007bff !important;
      border-color: #007bff !important;
    }

    .profile-name {
      font-size: 1.5rem;
      font-weight: 600;
      color: #8B4513;
      margin-bottom: 20px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .form-section {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .nav-tabs {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2691E 100%);
      border: none;
      margin: 0;
    }

    .nav-tabs .nav-link {
      color: rgba(255, 255, 255, 0.8);
      border: none;
      border-radius: 0;
      padding: 15px 25px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
      color: white;
      background: rgba(255, 255, 255, 0.1);
    }

    .nav-tabs .nav-link.active {
      color: #8B4513;
      background: white;
      border: none;
    }

    .tab-content {
      padding: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      display: block;
    }

    .form-control {
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 15px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #ffffff !important;
      color: #333 !important;
    }

    .form-control:focus {
      border-color: #8B4513;
      box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
      background: #ffffff !important;
      color: #333 !important;
    }
    
    /* Ensure all inputs have white background */
    input.form-control,
    textarea.form-control,
    select.form-control {
      background: #ffffff !important;
      color: #000000 !important;
      font-weight: 500 !important;
    }
    
    select.form-control option {
      background: #ffffff !important;
      color: #000000 !important;
      padding: 8px 12px !important;
    }
    
    /* Make selected option in dropdown more visible */
    select.form-control:not([multiple]):not([size]) {
      background: #ffffff !important;
      color: #000000 !important;
      font-weight: 600 !important;
    }
    
    /* Style for when dropdown has a selected value */
    select.form-control:not([value=""]) {
      color: #000000 !important;
      font-weight: 600 !important;
      background-color: #ffffff !important;
    }
    
    /* Make dropdown options more visible when opened */
    select.form-control option:checked,
    select.form-control option[selected] {
      background: #8B4513 !important;
      color: #ffffff !important;
      font-weight: 600 !important;
    }
    
    select.form-control option:hover {
      background: #D2691E !important;
      color: #ffffff !important;
    }
    
    /* Fix any dark input backgrounds */
    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="password"],
    input[type="number"],
    select,
    textarea {
      background-color: #ffffff !important;
      color: #000000 !important;
      font-weight: 500 !important;
    }
    
    /* Enhanced dropdown visibility */
    select {
      color: #000000 !important;
      font-weight: 600 !important;
    }
    
    select option {
      color: #000000 !important;
      background: #ffffff !important;
      padding: 10px 15px !important;
      font-size: 14px !important;
      font-weight: 500 !important;
    }
    
    select option:checked,
    select option[selected] {
      background: #8B4513 !important;
      color: #ffffff !important;
      font-weight: 700 !important;
    }
    
    select option:hover {
      background: #D2691E !important;
      color: #ffffff !important;
      font-weight: 600 !important;
    }

    .input-group-text {
      background: #8B4513;
      color: white;
      border: 2px solid #8B4513;
      border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
      border-left: none;
      border-radius: 0 10px 10px 0;
    }

    .btn-register {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-size: 14px;
      font-weight: 600;
      color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-register:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(102, 126, 234, 0.4);
    }

    .btn-back {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 3px 12px rgba(139, 69, 19, 0.3);
    }

    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(139, 69, 19, 0.4);
      color: white;
      text-decoration: none;
    }
    
    .btn-back {
      margin-right: 2rem !important;
    }

    .btn-back:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.2);
    }

    .section-title {
      color: #8B4513;
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
      position: relative;
    }
    
    /* Formal Account Information section - Match admin/addResidence.php */
    #account .lead {
      font-size: 1.2rem !important;
      margin-bottom: 30px !important;
      font-weight: 700 !important;
      color: #8B4513 !important;
      position: relative;
      padding-bottom: 15px;
    }
    
    #account .lead::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(90deg, transparent, #8B4513, transparent);
    }
    
    #account .form-group {
      margin-bottom: 25px !important;
    }
    
    #account .form-group label {
      font-weight: 600;
      color: #8B4513;
      margin-bottom: 10px;
      display: block;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    #account .input-group {
      margin-bottom: 0 !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    #account .input-group-text {
      padding: 8px 12px !important;
      font-size: 14px !important;
      background: transparent !important;
      border: 2px solid #8B4513 !important;
      color: #8B4513 !important;
    }
    
    #account .input-group-prepend .input-group-text {
      border-right: none !important;
      border-radius: 8px 0 0 8px !important;
    }
    
    #account .input-group-append .input-group-text {
      border-left: none !important;
      border-radius: 0 8px 8px 0 !important;
    }
    
    #account .form-control {
      padding: 8px 12px !important;
      font-size: 14px !important;
      border: 2px solid #8B4513 !important;
      background: #ffffff !important;
      color: #333 !important;
    }
    
    /* Username field - only prepend, no append */
    #account #add_username {
      border-left: none !important;
      border-radius: 0 8px 8px 0 !important;
    }
    
    /* Password and Confirm Password - both prepend and append */
    #account #add_password,
    #account #add_confirm_password {
      border-left: none !important;
      border-right: none !important;
      border-radius: 0 !important;
    }
    
    #account .form-control:focus {
      border-color: #8B4513 !important;
      box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25), 0 2px 10px rgba(139, 69, 19, 0.2) !important;
      outline: none !important;
    }
    
    #account .form-text {
      font-size: 12px !important;
      margin-top: 3px !important;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2691E 100%);
      border-radius: 2px;
    }

    .navbar {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2691E 100%) !important;
      box-shadow: 0 2px 10px rgba(139, 69, 19, 0.3);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.2rem;
    }

    .nav-link {
      transition: all 0.3s ease;
      border-radius: 5px;
      margin: 0 5px;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-2px);
    }

    .nav-link.active {
      background: rgba(255, 255, 255, 0.2);
      border-bottom: 3px solid #ff6b6b;
    }

    .footer {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2691E 100%);
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .main-container {
        margin: 10px;
        border-radius: 15px;
      }
      
      .form-container {
        padding: 20px;
      }
      
      .logo-section h1 {
        font-size: 1.8rem;
      }
      
      .profile-image {
        width: 120px;
        height: 120px;
      }
    }

    .card-footer {
      background: #f8f9fa;
      border-top: 1px solid #e9ecef;
      padding: 20px 30px;
      text-align: center;
    }

    /* Left Card Styling */
    .card.h-100 {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      border: 2px solid #e9ecef !important;
    }

    .card.h-100 .card-body {
      padding: 30px;
      border: none !important;
      border-radius: 15px;
    }

    .card.h-100 .form-group {
      margin-bottom: 20px;
    }

    .card.h-100 .form-group label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      display: block;
      font-size: 14px;
    }

    .card.h-100 .form-control {
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 15px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #ffffff !important;
      color: #333 !important;
    }

    .card.h-100 .form-control:focus {
      border-color: #8B4513;
      box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
      background: #ffffff !important;
      color: #333 !important;
    }

    .card.h-100 select.form-control {
      background: #ffffff !important;
      color: #333 !important;
    }

    .card.h-100 select.form-control option {
      background: #ffffff !important;
      color: #333 !important;
    }

    .card.h-100 input[type="text"],
    .card.h-100 input[type="date"],
    .card.h-100 select {
      color: #333 !important;
      background: white !important;
    }

    .card.h-100 input[type="text"]:focus,
    .card.h-100 input[type="date"]:focus,
    .card.h-100 select:focus {
      color: #333 !important;
      background: white !important;
    }

    /* SweetAlert2 Custom Styling */
    .swal-wide {
      width: 650px !important;
    }

    .swal2-popup {
      border-radius: 15px !important;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .swal2-title {
      font-size: 24px !important;
      font-weight: 700 !important;
    }

    .swal2-html-container {
      font-size: 16px !important;
      line-height: 1.6 !important;
    }
  </style>


</head>
<body class="hold-transition layout-top-nav dark-mode">


<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md " style="background-color: #0037af">
    <div class="container">
      <a href="" class="navbar-brand">
        <?php 
        $logo_path = 'assets/dist/img/' . $image;
        if (!empty($image) && file_exists($logo_path)) {
          $logo_src = $logo_path;
        } else {
          $logo_src = 'assets/dist/img/logo.png';
        }
        ?>
        <img src="<?= $logo_src ?>" alt="logo" class="brand-image img-circle " >
        <span class="brand-text  text-white"  style="font-weight: 700">IPs PORTAL</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->


       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto " >
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="backGround">
    <!-- Content Header (Page header) -->
 
    
  
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" >

  



    
       
              <div class="container-fluid py-5">

<form id="registerResidentForm" method="POST" enctype="multipart/form-data" autocomplete="off">
<!-- Profile Section -->
<div class="profile-section">
  <img class="profile-image" src="assets/dist/img/blank_image.png" alt="User profile picture" id="image_residence">
  <input type="file" name="add_image_residence" id="add_image_residence" style="display: none;">
  <div id="image_required_text" style="display: none; color: #dc3545; font-size: 12px; margin-top: 5px; text-align: center;">* Profile Picture Required</div>
  <div class="profile-name">
    <span id="keyup_first_name"></span> <span id="keyup_last_name"></span>
  </div>
</div>

<div class="row mb-3">
  <div class="col-sm-4">
    <div class="card h-100">
      <div class="card-body" style="border: 10px solid rgba(0,54,175,.75); border-radius: 0;">


        <div class="row">
          <div class="col-sm-12">
            <div class="form-group ">
              <label >Place of Birth</label>
              <input type="text" class="form-control" id="add_birth_place" name="add_birth_place" required>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group ">
              <label >Date of Birth</label>
              <input type="date" class="form-control" id="add_birth_date" name="add_birth_date">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group ">
              <label >Gender</label>
              <select name="add_gender" id="add_gender" class="form-control">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group ">
              <label >Age</label>
              <input type="text" class="form-control" id="add_age" name="add_age" readonly style="background-color: #e9ecef; cursor: not-allowed;" placeholder="Auto-calculated from Date of Birth">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group ">
              <label >Civil Status</label>
                  <select name="add_civil_status" id="add_civil_status" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                    <option value="Annulled / Divorced">Annulled / Divorced</option>
                  </select>
                  <small id="civil_status_age_restriction" class="form-text text-muted" style="display: none; color: #dc3545 !important; font-weight: 500;">
                    <i class="fas fa-info-circle"></i> Other options are not available - Under 18 years old
                  </small>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>IP Status</label>
              <select name="add_ip_status" id="add_ip_status" class="form-control" required>
                <option value="">Select</option>
                <option value="IP Living Inside">IP Living Inside</option>
                <option value="IP Living Outside">IP Living Outside</option>
                <option value="IP Migrant">IP Migrant</option>
                      </select>
                    </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>CADT/ AD <small class="text-muted">(Optional)</small></label>
              <input type="text" class="form-control" id="add_cadt_ad" name="add_cadt_ad" placeholder="Enter CADT/AD">
            </div>
          </div>
          <div class="col-sm-6" id="household_number_wrapper" style="display: none;">
            <div class="form-group">
              <label>Household # <small class="text-muted">(Optional)</small></label>
              <input type="text" class="form-control" id="add_household_number" name="add_household_number" placeholder="Enter Household Number">
            </div>
          </div>
          <div class="col-sm-6" id="family_number_wrapper" style="display: none;">
            <div class="form-group">
              <label>Contact Number of the Family</label>
              <input type="text" class="form-control" id="add_family_number" name="add_family_number" placeholder="Enter Contact Number (e.g., 09111111111)" maxlength="11">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add_voters" id="add_voters" value="YES">
                <label class="form-check-label" for="add_voters">Voters</label>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input senior-checkbox" type="checkbox" name="add_senior" id="add_senior" value="YES" disabled style="cursor: not-allowed;">
                <label class="form-check-label" for="add_senior" style="opacity: 1;">Senior Citizen</label>
                <input type="hidden" name="add_senior" id="add_senior_hidden" value="NO">
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add_pwd" id="add_pwd" value="YES">
                <label class="form-check-label" for="add_pwd">PWD</label>
              </div>
                    </div>
                  </div>
                  <div class="col-sm-12" id="pwd_check" style="display: none;">
                    <div class="form-group ">
                      <label >TYPE OF PWD</label>
                        <input type="text" class="form-control" id="add_pwd_info" name="add_pwd_info">
                    </div>
                  </div>
        </div>



       
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <div class="col-sm-8">
    <div class="form-section">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="family-profile-tab" data-toggle="pill" href="#family-profile" role="tab" aria-controls="family-profile" aria-selected="true">Profile Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="false">Account Information</a>
          </li>
        </ul>
      </div>
      <div class="card-body" >
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane fade active show" id="family-profile" role="tabpanel" aria-labelledby="family-profile-tab">
            <div class="section-title">Profile Information</div>
            
            <!-- Personal Details -->
            <div class="row mb-4">
              <div class="col-12">
                <h5 style="color: #8B4513; font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid #8B4513; padding-bottom: 10px;">
                  <i class="fas fa-user"></i> Personal Details
                </h5>
                  </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Surname</label>
                  <input type="text" class="form-control" id="add_family_surname" name="add_family_surname" placeholder="Enter surname" required>
                </div>
                  </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" id="add_family_first_name" name="add_family_first_name" placeholder="Enter first name" required>
                </div>
                  </div>  
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Middle Name</label>
                  <input type="text" class="form-control" id="add_family_middle_name" name="add_family_middle_name" placeholder="Enter middle name">
                </div>
              </div>
                  <div class="col-sm-6">
                <div class="form-group">
                  <label>IP Group</label>
                  <select name="add_family_tribe" id="add_family_tribe" class="form-control" required>
                    <option value="">Select</option>
                        <option value="Manobo">Manobo</option>
                        <option value="Mandaya">Mandaya</option>
                        <option value="Others">Others</option>
                      </select>
                  <div id="custom_family_tribe_div" style="display: none; margin-top: 10px;">
                    <label>Specify IP Group:</label>
                    <input type="text" class="form-control" id="add_custom_family_tribe" name="add_custom_family_tribe" placeholder="Enter IP Group name">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                <div class="form-group">
                  <label>Religion</label>
                  <input type="text" class="form-control" id="add_family_religion" name="add_family_religion" placeholder="Enter religion" required>
                    </div>
                  </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Sitio/Purok/Barangay/Munisipyo/Probinsya</label>
                  <input type="text" class="form-control" id="add_sitio_purok" name="add_sitio_purok" placeholder="Enter complete address" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                <div class="form-group">
                  <label>Place of Origin</label>
                  <input type="text" class="form-control" id="add_place_of_origin" name="add_place_of_origin" placeholder="Enter place of origin" required>
                    </div>
                  </div>                              
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Registered with Local Civil Registry Office?</label>
                  <select name="add_registered_civil_registry" id="add_registered_civil_registry" class="form-control" required>
                    <option value="">Select</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                      </select>
                </div>
          </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Vaccinated against</label>
                  <input type="text" class="form-control" id="add_vaccinated_against" name="add_vaccinated_against" placeholder="Enter vaccination information">
                </div>
              </div>
              <div class="col-sm-4" id="contact_number_div">
                <div class="form-group">
                  <label>Contact Number</label>
                  <input type="text" class="form-control" id="add_contact_number" name="add_contact_number" placeholder="Enter contact number (e.g., 09111111111)" maxlength="11">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Beneficiary</label>
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_philhealth" value="Philhealth">
                        <label class="form-check-label" for="beneficiary_philhealth">Philhealth</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_sss" value="SSS">
                        <label class="form-check-label" for="beneficiary_sss">SSS</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_gsis" value="GSIS">
                        <label class="form-check-label" for="beneficiary_gsis">GSIS</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_4ps" value="4Ps">
                        <label class="form-check-label" for="beneficiary_4ps">4Ps</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_senior" value="Senior Citizen">
                        <label class="form-check-label" for="beneficiary_senior">Senior Citizen</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_pwd" value="PWD" disabled>
                        <label class="form-check-label" for="beneficiary_pwd" style="opacity: 0.6; cursor: not-allowed;">PWD</label>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="beneficiary[]" id="beneficiary_others" value="Others">
                        <label class="form-check-label" for="beneficiary_others">Others (specify)</label>
                      </div>
                      <input type="text" class="form-control mt-2" id="add_beneficiary_others" name="add_beneficiary_others" placeholder="Specify other beneficiary" style="display: none;">
                    </div>
                  </div>
                </div>
                    </div>
                  </div>

            <!-- Wife/Husband Information -->
            <div class="row mb-4" id="wife_husband_section">
              <div class="col-12">
                <h5 style="color: #8B4513; font-weight: 600; margin-bottom: 20px; border-bottom: 2px solid #8B4513; padding-bottom: 10px;">
                  <i class="fas fa-user-friends"></i> Wife/Husband Information
                  <small class="text-muted" id="wife_husband_optional_label" style="display: none;"> (Optional)</small>
                </h5>
                  </div>                              
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>Surname</label>
                  <input type="text" class="form-control" id="add_spouse_surname" name="add_spouse_surname" placeholder="Enter surname">
                </div>
          </div>
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" id="add_spouse_first_name" name="add_spouse_first_name" placeholder="Enter first name">
                    </div>
                  </div>
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>Middle Name</label>
                  <input type="text" class="form-control" id="add_spouse_middle_name" name="add_spouse_middle_name" placeholder="Enter middle name">
                    </div>
                  </div>
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>Spouse Sex</label>
                  <select name="add_spouse_sex" id="add_spouse_sex" class="form-control">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                    </div>
                  </div>
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>Spouse Birthday (mm/dd/year)</label>
                  <input type="date" class="form-control" id="add_spouse_birthday" name="add_spouse_birthday">
                    </div>
                  </div>
              <div class="col-sm-4">
                    <div class="form-group">
                  <label>Spouse Age</label>
                  <input type="text" class="form-control" id="add_spouse_age" name="add_spouse_age" readonly style="cursor: not-allowed;" placeholder="Auto-calculated from Birthday">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                  <label>Spouse IP Group</label>
                  <select name="add_spouse_ip_group" id="add_spouse_ip_group" class="form-control">
                    <option value="">--SELECT IP GROUP--</option>
                        <option value="Manobo">Manobo</option>
                        <option value="Mandaya">Mandaya</option>
                        <option value="Others">Others</option>
                      </select>
                  <div id="custom_spouse_ip_group_div" style="display: none; margin-top: 10px;">
                    <label>Specify IP Group:</label>
                    <input type="text" class="form-control form-control-sm" id="add_custom_spouse_ip_group" name="add_custom_spouse_ip_group" placeholder="Enter IP Group name">
                  </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                  <label>Spouse Place of Origin</label>
                  <input type="text" class="form-control" id="add_spouse_place_of_origin" name="add_spouse_place_of_origin" placeholder="Enter place of origin">
                    </div>
                  </div>
                </div>
              <div class="row">
                  <div class="col-sm-3" id="spouse_civil_status_wrapper">
                  <div class="form-group">
                      <label>Spouse Civil Status</label>
                      <select name="add_spouse_civil_status" id="add_spouse_civil_status" class="form-control" disabled style="cursor: not-allowed;">
                        <option value="">Select</option>
                        <option value="Married" selected>Married</option>
                        <option value="Separated">Separated</option>
                        <option value="Annulled / Divorced">Annulled / Divorced</option>
                      </select>
                      <input type="hidden" name="add_spouse_civil_status" id="add_spouse_civil_status_hidden" value="Married">
                  </div>
                </div>
                  <div class="col-sm-5">
                  <div class="form-group">
                      <label>Spouse Registered with Local Civil Registry Office?</label>
                      <select name="add_spouse_registered_civil_registry" id="add_spouse_registered_civil_registry" class="form-control">
                        <option value="">Select</option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Vaccinated against</label>
                      <input type="text" class="form-control" id="add_spouse_vaccinated_against" name="add_spouse_vaccinated_against" placeholder="Enter vaccination information">
                    </div>
                  </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="add_spouse_pwd" id="add_spouse_pwd" value="YES">
                    <label class="form-check-label" for="add_spouse_pwd">PWD</label>
                </div>
          </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="add_spouse_registered_voter" id="add_spouse_registered_voter" value="YES">
                    <label class="form-check-label" for="add_spouse_registered_voter">Spouse Registered Voter?</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input senior-checkbox" type="checkbox" name="add_spouse_senior" id="add_spouse_senior" value="YES" disabled style="cursor: not-allowed;">
                    <label class="form-check-label" for="add_spouse_senior" style="opacity: 1;">Senior Citizen</label>
                    <input type="hidden" name="add_spouse_senior" id="add_spouse_senior_hidden" value="NO">
                  </div>
                </div>
              </div>
              <div class="col-sm-6" id="spouse_pwd_check" style="display: none;">
                  <div class="form-group">
                  <label>TYPE OF PWD</label>
                  <input type="text" class="form-control" id="add_spouse_pwd_info" name="add_spouse_pwd_info" placeholder="Enter type of PWD">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                  <label>Spouse Beneficiary</label>
                  <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_philhealth" value="Philhealth">
                        <label class="form-check-label" for="spouse_beneficiary_philhealth">Philhealth</label>
                  </div>
                </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_sss" value="SSS">
                        <label class="form-check-label" for="spouse_beneficiary_sss">SSS</label>
              </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_gsis" value="GSIS">
                        <label class="form-check-label" for="spouse_beneficiary_gsis">GSIS</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_4ps" value="4Ps">
                        <label class="form-check-label" for="spouse_beneficiary_4ps">4Ps</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_senior" value="Senior Citizen">
                        <label class="form-check-label" for="spouse_beneficiary_senior">Senior Citizen</label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_pwd" value="PWD" disabled>
                        <label class="form-check-label" for="spouse_beneficiary_pwd" style="opacity: 0.6; cursor: not-allowed;">PWD</label>
                  </div>
                </div>
                <div class="col-sm-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="spouse_beneficiary[]" id="spouse_beneficiary_others" value="Others">
                        <label class="form-check-label" for="spouse_beneficiary_others">Others (specify)</label>
                  </div>
                      <input type="text" class="form-control mt-2" id="add_spouse_beneficiary_others" name="add_spouse_beneficiary_others" placeholder="Specify other beneficiary" style="display: none;">
                </div>
              </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <p class="lead text-center" style="font-size: 1.2rem; margin-bottom: 30px; font-weight: 700; color: #8B4513; position: relative; padding-bottom: 15px;">Account Information</p>
                    <div class="row justify-content-center">
                      <div class="col-sm-12 col-md-8 col-lg-6">
                        <div class="form-group" style="margin-bottom: 25px;">
                          <label for="add_username" style="font-weight: 600; color: #8B4513; margin-bottom: 10px; display: block; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Username</label>
                          <div class="input-group" style="margin-bottom: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-transparent" style="padding: 8px 12px;"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="add_username" name="add_username" class="form-control" placeholder="USERNAME" required style="padding: 8px 12px; font-size: 14px;">
                          </div>
                          <small class="form-text text-muted" style="font-size: 12px; margin-top: 8px; display: block; font-style: italic;">Username must be at least 8 characters long</small>
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-sm-12 col-md-8 col-lg-6">
                        <div class="form-group" style="margin-bottom: 25px;">
                          <label for="add_password" style="font-weight: 600; color: #8B4513; margin-bottom: 10px; display: block; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Password</label>
                          <div class="input-group" style="margin-bottom: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);" id="show_hide_password">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-transparent" style="padding: 8px 12px;"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="add_password" name="add_password" class="form-control" placeholder="PASSWORD" style="border-right: none; padding: 8px 12px; font-size: 14px;" required>
                            <div class="input-group-append">
                              <span class="input-group-text bg-transparent" style="cursor: pointer; padding: 8px 12px;"><i class="fas fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                          </div>
                          <small class="form-text text-muted" style="font-size: 12px; margin-top: 8px; display: block; font-style: italic;">Password must be at least 8 characters long</small>
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-sm-12 col-md-8 col-lg-6">
                        <div class="form-group" style="margin-bottom: 25px;">
                          <label for="add_confirm_password" style="font-weight: 600; color: #8B4513; margin-bottom: 10px; display: block; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Confirm Password</label>
                          <div class="input-group" style="margin-bottom: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);" id="show_hide_password_confirm">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-transparent" style="padding: 8px 12px;"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="add_confirm_password" name="add_confirm_password" class="form-control" placeholder="CONFIRM PASSWORD" style="border-right: none; padding: 8px 12px; font-size: 14px;" required>
                            <div class="input-group-append">
                              <span class="input-group-text bg-transparent" style="cursor: pointer; padding: 8px 12px;"><i class="fas fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                          </div>
                          <small class="form-text text-muted" style="font-size: 12px; margin-top: 8px; display: block; font-style: italic;">Re-enter password to confirm</small>
                        </div>
                      </div>
                    </div>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-center align-items-center">
        <button type="button" onclick="window.location.href='login.php'" class="btn btn-back me-5">
          <i class="fas fa-arrow-left"></i> Back to Login
        </button>
        <button type="submit" class="btn btn-register"> <i class="fas fa-user-plus"></i> REGISTER</button>
      </div>
      
      <!-- Registration Progress Notice -->
      <div class="alert alert-info mt-3" id="progressNotice" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: 2px solid #2196f3; border-radius: 12px; color: #1565c0;">
        <div class="d-flex align-items-center">
          <i class="fas fa-info-circle fa-2x me-3" style="color: #2196f3;"></i>
          <div>
            <h6 class="mb-2" style="color: #0d47a1; font-weight: 600;">
              <i class="fas fa-clipboard-list me-2"></i>Registration Progress
            </h6>
            <p class="mb-1" style="color: #1565c0; font-size: 14px; line-height: 1.4;">
              <strong>Complete all sections to register successfully:</strong>
            </p>
            <div class="row">
              <div class="col-md-6 col-sm-6 mb-2">
                <div class="d-flex align-items-center">
                  <i class="fas fa-info-circle me-2" style="color: #2196f3;"></i>
                  <i class="fas fa-users me-2" style="color: #8B4513;"></i>
                  <span id="familyProfileStatus" style="font-size: 13px; font-weight: 500;">Profile Information</span>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 mb-2">
                <div class="d-flex align-items-center">
                  <i class="fas fa-key me-2" style="color: #8B4513;"></i>
                  <span id="accountStatus" style="font-size: 13px; font-weight: 500;">Account Information</span>
                </div>
              </div>
            </div>
            <p class="mt-2 mb-0" style="color: #0d47a1; font-size: 12px; font-weight: 500;">
              <i class="fas fa-lightbulb me-1"></i> Click on each tab above to navigate between sections and fill all required fields.
            </p>
          </div>
        </div>
      </div> 
      <!-- /.card -->
    </div>

  </div>
        </div>
      </div>
    </div>
</form>
</div><!--/. form-container -->
</div><!--/. main-container -->
</div><!--/. container-fluid -->
          
     
          

     
          
               
      
     
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
  <footer class="footer">
    <div class="container">
      <i class="fas fa-map-marker-alt"></i> <?= $postal_address ?>
    </div>
  </footer>
 


</div>
<!-- ./wrapper -->





<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>
<script src="assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="assets/plugins/sweetalert2/js/sweetalert2.all.min.js"></script>
<script src="assets/plugins/step-wizard/js/jquery.smartWizard.min.js"></script>
<script>
  // Function to handle Wife/Husband Information section visibility
  function handleWifeHusbandSection() {
    var civilStatusSelect = $("#add_civil_status");
    var civilStatus = civilStatusSelect.val() || civilStatusSelect.find('option:selected').val() || '';
    var selectedText = civilStatusSelect.find('option:selected').text().trim();
    var wifeHusbandSection = $("#wife_husband_section");
    var optionalLabel = $("#wife_husband_optional_label");
    
    // Also check by text if value is empty but text matches
    if(!civilStatus && selectedText === 'Single') {
      civilStatus = 'Single';
    }
    
    
    if(civilStatus == 'Married' || selectedText == 'Married' || 
       civilStatus == 'Widowed' || selectedText == 'Widowed' ||
       civilStatus == 'Separated' || selectedText == 'Separated' ||
       civilStatus == 'Annulled / Divorced' || selectedText == 'Annulled / Divorced'){
      $('body').removeClass('civil-status-single');
      wifeHusbandSection.removeClass('d-none');
      wifeHusbandSection.removeAttr('data-hidden');
      wifeHusbandSection.css({
        'display': '',
        'visibility': '',
        'height': '',
        'overflow': '',
        'opacity': ''
      });
      wifeHusbandSection.show();
      optionalLabel.hide();
      $("#add_spouse_surname").prop('required', true);
      $("#add_spouse_first_name").prop('required', true);
      
      // Set spouse civil status based on main civil status
      if(civilStatus == 'Married' || selectedText == 'Married'){
        $("#add_spouse_civil_status").val('Married');
        $("#add_spouse_civil_status_hidden").val('Married');
      } else if(civilStatus == 'Widowed' || selectedText == 'Widowed'){
        $("#add_spouse_civil_status").val('Married');
        $("#add_spouse_civil_status_hidden").val('Married');
      } else if(civilStatus == 'Separated' || selectedText == 'Separated'){
        $("#add_spouse_civil_status").val('Separated');
        $("#add_spouse_civil_status_hidden").val('Separated');
      } else if(civilStatus == 'Annulled / Divorced' || selectedText == 'Annulled / Divorced'){
        $("#add_spouse_civil_status").val('Annulled / Divorced');
        $("#add_spouse_civil_status_hidden").val('Annulled / Divorced');
      }
      
      // Show Spouse Civil Status field
      $("#spouse_civil_status_wrapper").show();
      // Show all spouse-related fields
      $("#add_spouse_registered_civil_registry").closest('.form-group, .col-sm-5').show();
      $("#add_spouse_pwd").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_registered_voter").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_senior").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_vaccinated_against").closest('.form-group, .col-sm-4').show();
      $("label:contains('Spouse Beneficiary')").closest('.form-group, .col-sm-12').show();
      $("input[name='spouse_beneficiary[]']").closest('.form-group, .form-check, .col-sm-6, .col-md-4').show();
      $("#add_spouse_beneficiary_others").closest('.form-group, .col-sm-12').show();
    } else if(civilStatus == 'Single' || selectedText == 'Single') {
      // Single - show spouse section but make it optional
      $('body').removeClass('civil-status-single');
      wifeHusbandSection.removeClass('d-none');
      wifeHusbandSection.removeAttr('data-hidden');
      wifeHusbandSection.css({
        'display': '',
        'visibility': '',
        'height': '',
        'overflow': '',
        'opacity': ''
      });
      wifeHusbandSection.show();
      optionalLabel.show();
      
      // Make fields optional (not required)
      $("#add_spouse_surname").prop('required', false);
      $("#add_spouse_first_name").prop('required', false);
      $("#add_spouse_middle_name").prop('required', false);
      
      // Show Spouse Civil Status field but make it optional
      $("#spouse_civil_status_wrapper").show();
      // Show all spouse-related fields
      $("#add_spouse_registered_civil_registry").closest('.form-group, .col-sm-5').show();
      $("#add_spouse_pwd").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_registered_voter").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_senior").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_vaccinated_against").closest('.form-group, .col-sm-4').show();
      $("label:contains('Spouse Beneficiary')").closest('.form-group, .col-sm-12').show();
      $("input[name='spouse_beneficiary[]']").closest('.form-group, .form-check, .col-sm-6, .col-md-4').show();
      $("#add_spouse_beneficiary_others").closest('.form-group, .col-sm-12').show();
      
      // Clear spouse civil status (let user choose or leave empty)
      $("#add_spouse_civil_status").val('');
      $("#add_spouse_civil_status_hidden").val('');
    } else {
      // Empty/initial state - show spouse section but make it optional (for Single users who want to add spouse info)
      $('body').removeClass('civil-status-single');
      wifeHusbandSection.removeClass('d-none');
      wifeHusbandSection.removeAttr('data-hidden');
      wifeHusbandSection.css({
        'display': '',
        'visibility': '',
        'height': '',
        'overflow': '',
        'opacity': ''
      });
      wifeHusbandSection.show();
      optionalLabel.show();
      
      // Make fields optional (not required)
      $("#add_spouse_surname").prop('required', false);
      $("#add_spouse_first_name").prop('required', false);
      $("#add_spouse_middle_name").prop('required', false);
      
      // Show Spouse Civil Status field but make it optional
      $("#spouse_civil_status_wrapper").show();
      // Show all spouse-related fields
      $("#add_spouse_registered_civil_registry").closest('.form-group, .col-sm-5').show();
      $("#add_spouse_pwd").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_registered_voter").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_senior").closest('.form-group, .col-sm-4').show();
      $("#add_spouse_vaccinated_against").closest('.form-group, .col-sm-4').show();
      $("label:contains('Spouse Beneficiary')").closest('.form-group, .col-sm-12').show();
      $("input[name='spouse_beneficiary[]']").closest('.form-group, .form-check, .col-sm-6, .col-md-4').show();
      $("#add_spouse_beneficiary_others").closest('.form-group, .col-sm-12').show();
      
      // Clear spouse civil status (let user choose or leave empty)
      $("#add_spouse_civil_status").val('');
      $("#add_spouse_civil_status_hidden").val('');
      
      // Clear spouse fields and remove required
      $("#add_spouse_surname").prop('required', false).val('');
      $("#add_spouse_first_name").prop('required', false).val('');
      $("#add_spouse_middle_name").prop('required', false).val('');
      $("#add_spouse_sex").val('');
      $("#add_spouse_age").val('');
      $("#add_spouse_birthday").val('');
      $("#add_spouse_ip_group").val('');
      $("#add_custom_spouse_ip_group").val('').hide();
      $("#custom_spouse_ip_group_div").hide();
      $("#add_spouse_place_of_origin").val('');
      $("#add_spouse_registered_voter").prop('checked', false);
      $("#add_spouse_civil_status").val('');
      $("#add_spouse_registered_civil_registry").val('');
      $("#add_spouse_pwd").prop('checked', false);
      $("#add_spouse_pwd_info").val('');
      $("#spouse_pwd_check").hide();
      $("#add_spouse_senior").prop('checked', false);
      $("#add_spouse_senior_hidden").val('NO');
      $("#add_spouse_vaccinated_against").val('');
      // Clear spouse beneficiary fields
      $("input[name='spouse_beneficiary[]']").prop('checked', false);
      $("#add_spouse_beneficiary_others").val('').hide();
    }
  }

  // Initialize spouse section visibility on page load
  $(function() {
    // Don't hide by default - let handleWifeHusbandSection() decide
    // The function will show it if Single is selected or other statuses
  });

  $(document).ready(function(){
    // Initialize PWD beneficiary checkboxes - disable if PWD is not checked
    if(!$("#add_pwd").is(':checked')){
      $("#beneficiary_pwd").prop('disabled', true);
      $("#beneficiary_pwd").closest('.form-check').find('label').css({
        'opacity': '0.6',
        'cursor': 'not-allowed'
      });
    }
    if(!$("#add_spouse_pwd").is(':checked')){
      $("#spouse_beneficiary_pwd").prop('disabled', true);
      $("#spouse_beneficiary_pwd").closest('.form-check').find('label').css({
        'opacity': '0.6',
        'cursor': 'not-allowed'
      });
    }
    
    // Initialize Wife/Husband section visibility on page load
    handleWifeHusbandSection();
    
    // Restrict Civil Status based on age on page load
    restrictCivilStatusByAge();
    
    // Also check on window load
    $(window).on('load', function() {
      handleWifeHusbandSection();
      restrictCivilStatusByAge();
    });
    
    // Call immediately after a short delay to ensure it's hidden
    setTimeout(function() {
      handleWifeHusbandSection();
    }, 100);
    
    
    // Function to apply blue color to checked disabled senior checkboxes
    function applySeniorCheckboxColor(){
      if($("#add_senior").is(':checked')){
        $("#add_senior").addClass('senior-checked');
        $("#add_senior").css({
          'background-color': '#007bff',
          'border-color': '#007bff',
          'opacity': '1',
          'background-image': 'url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\'%3e%3cpath fill=\'none\' stroke=\'%23fff\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'3\' d=\'M6 10l3 3l6-6\'/%3e%3c/svg%3e")'
        });
      } else {
        $("#add_senior").removeClass('senior-checked');
        $("#add_senior").css({
          'background-color': '',
          'border-color': '',
          'background-image': ''
        });
      }
      if($("#add_spouse_senior").is(':checked')){
        $("#add_spouse_senior").addClass('senior-checked');
        $("#add_spouse_senior").css({
          'background-color': '#007bff',
          'border-color': '#007bff',
          'opacity': '1',
          'background-image': 'url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\'%3e%3cpath fill=\'none\' stroke=\'%23fff\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'3\' d=\'M6 10l3 3l6-6\'/%3e%3c/svg%3e")'
        });
      } else {
        $("#add_spouse_senior").removeClass('senior-checked');
        $("#add_spouse_senior").css({
          'background-color': '',
          'border-color': '',
          'background-image': ''
        });
      }
    }
    
    // Apply color on page load with multiple attempts
    setTimeout(applySeniorCheckboxColor, 50);
    setTimeout(applySeniorCheckboxColor, 100);
    setTimeout(applySeniorCheckboxColor, 200);
    setTimeout(applySeniorCheckboxColor, 500);
    
    // Monitor for changes more frequently
    setInterval(applySeniorCheckboxColor, 100);
 
    $("#add_pwd").change(function(){
      var pwd_check = $(this).is(':checked');

      if(pwd_check){
        $("#pwd_check").css('display', 'block');
        $("#add_pwd_info").prop('disabled', false);
        // Enable PWD beneficiary checkbox
        $("#beneficiary_pwd").prop('disabled', false);
        $("#beneficiary_pwd").closest('.form-check').find('label').css({
          'opacity': '1',
          'cursor': 'pointer'
        });
      }else{
        $("#pwd_check").css('display', 'none');
        $("#add_pwd_info").prop('disabled', true);
        $("#add_pwd_info").val('');
        // Disable and uncheck PWD beneficiary checkbox
        $("#beneficiary_pwd").prop('disabled', true).prop('checked', false);
        $("#beneficiary_pwd").closest('.form-check').find('label').css({
          'opacity': '0.6',
          'cursor': 'not-allowed'
        });
      }

    });

    // Handle Spouse PWD checkbox
    $("#add_spouse_pwd").change(function(){
      var spouse_pwd_check = $(this).is(':checked');
      
      if(spouse_pwd_check){
        $("#spouse_pwd_check").css('display', 'block');
        $("#add_spouse_pwd_info").prop('disabled', false);
        // Enable Spouse PWD beneficiary checkbox
        $("#spouse_beneficiary_pwd").prop('disabled', false);
        $("#spouse_beneficiary_pwd").closest('.form-check').find('label').css({
          'opacity': '1',
          'cursor': 'pointer'
        });
      } else {
        $("#spouse_pwd_check").css('display', 'none');
        $("#add_spouse_pwd_info").prop('disabled', true);
        $("#add_spouse_pwd_info").val('');
        // Disable and uncheck Spouse PWD beneficiary checkbox
        $("#spouse_beneficiary_pwd").prop('disabled', true).prop('checked', false);
        $("#spouse_beneficiary_pwd").closest('.form-check').find('label').css({
          'opacity': '0.6',
          'cursor': 'not-allowed'
        });
      }
    });

    // Auto-calculate Age from Date of Birth
    // Function to restrict Civil Status based on age
    function restrictCivilStatusByAge() {
      var age = parseInt($("#add_age").val()) || 0;
      var civilStatusSelect = $("#add_civil_status");
      var currentValue = civilStatusSelect.val();
      var restrictionMessage = $("#civil_status_age_restriction");
      
      if(age < 18 && age > 0) {
        // If age is below 18, disable all options except Single
        civilStatusSelect.find('option').each(function() {
          var optionValue = $(this).val();
          if(optionValue === '' || optionValue === 'Single') {
            $(this).prop('disabled', false);
          } else {
            $(this).prop('disabled', true);
          }
        });
        
        // Show restriction message
        restrictionMessage.show();
        
        // If current selection is not Single or empty, reset to Single
        if(currentValue && currentValue !== 'Single' && currentValue !== '') {
          civilStatusSelect.val('Single');
          handleWifeHusbandSection();
        }
      } else {
        // If age is 18 or above, enable all options
        civilStatusSelect.find('option').prop('disabled', false);
        // Hide restriction message
        restrictionMessage.hide();
      }
    }
    
    $("#add_birth_date").on('change', function(){
      var birthDate = $(this).val();
      if(birthDate){
        var today = new Date();
        var birth = new Date(birthDate);
        var age = today.getFullYear() - birth.getFullYear();
        var monthDiff = today.getMonth() - birth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
          age--;
        }
        $("#add_age").val(age);
        
        // Restrict Civil Status based on age
        restrictCivilStatusByAge();
        
        // Handle Voters checkbox based on age (must be 18 or above)
        if(age < 18){
          // Disable and uncheck Voters if below 18 years old
          $("#add_voters").prop('disabled', true);
          $("#add_voters").prop('checked', false);
          $("#add_voters").closest('.form-check').find('label').css('opacity', '0.6');
          $("#add_voters").css('cursor', 'not-allowed');
        } else {
          // Enable Voters if 18 years old or above
          $("#add_voters").prop('disabled', false);
          $("#add_voters").closest('.form-check').find('label').css('opacity', '1');
          $("#add_voters").css('cursor', 'pointer');
        }
        
        // Auto-check Senior Citizen if age >= 60
        if(age >= 60){
          $("#add_senior").prop('checked', true);
          $("#add_senior_hidden").val('YES');
          // Force blue color for checked disabled checkbox
          $("#add_senior").addClass('senior-checked');
          // Use setTimeout to ensure CSS is applied after Bootstrap styles
          setTimeout(function(){
            $("#add_senior").css({
              'background-color': '#007bff',
              'border-color': '#007bff',
              'opacity': '1',
              'background-image': 'url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\'%3e%3cpath fill=\'none\' stroke=\'%23fff\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'3\' d=\'M6 10l3 3l6-6\'/%3e%3c/svg%3e")'
            });
          }, 50);
        } else {
          $("#add_senior").prop('checked', false);
          $("#add_senior_hidden").val('NO');
          $("#add_senior").removeClass('senior-checked');
        }
      } else {
        $("#add_age").val('');
        // Disable Voters if no birth date
        $("#add_voters").prop('disabled', true);
        $("#add_voters").prop('checked', false);
        $("#add_voters").closest('.form-check').find('label').css('opacity', '0.6');
        $("#add_voters").css('cursor', 'not-allowed');
        $("#add_senior").prop('checked', false);
        $("#add_senior_hidden").val('NO');
        $("#add_senior").css({
          'background-color': '',
          'border-color': '',
          'opacity': '1'
        });
      }
    });

    // Auto-calculate Spouse Age from Spouse Birthday
    $("#add_spouse_birthday").on('change', function(){
      var spouseBirthDate = $(this).val();
      if(spouseBirthDate){
        var today = new Date();
        var spouseBirth = new Date(spouseBirthDate);
        var spouseAge = today.getFullYear() - spouseBirth.getFullYear();
        var monthDiff = today.getMonth() - spouseBirth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < spouseBirth.getDate())) {
          spouseAge--;
        }
        $("#add_spouse_age").val(spouseAge);
        
        // Auto-check Spouse Senior Citizen if age >= 60
        if(spouseAge >= 60){
          $("#add_spouse_senior").prop('checked', true);
          $("#add_spouse_senior_hidden").val('YES');
          // Force blue color for checked disabled checkbox
          $("#add_spouse_senior").addClass('senior-checked');
          // Use setTimeout to ensure CSS is applied after Bootstrap styles
          setTimeout(function(){
            $("#add_spouse_senior").css({
              'background-color': '#007bff',
              'border-color': '#007bff',
              'opacity': '1',
              'background-image': 'url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\'%3e%3cpath fill=\'none\' stroke=\'%23fff\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'3\' d=\'M6 10l3 3l6-6\'/%3e%3c/svg%3e")'
            });
          }, 50);
        } else {
          $("#add_spouse_senior").prop('checked', false);
          $("#add_spouse_senior_hidden").val('NO');
          $("#add_spouse_senior").removeClass('senior-checked');
        }
      } else {
        $("#add_spouse_age").val('');
        $("#add_spouse_senior").prop('checked', false);
        $("#add_spouse_senior_hidden").val('NO');
        $("#add_spouse_senior").css({
          'background-color': '',
          'border-color': '',
          'opacity': '1'
        });
      }
    });

    // Show/hide Wife/Husband Information section based on Civil Status
    $("#add_civil_status").on('change', function(){
      handleWifeHusbandSection();
      
      // Handle Household # field visibility based on Civil Status
      var civilStatus = $(this).val();
      var householdNumberWrapper = $("#household_number_wrapper");
      if(civilStatus == 'Single'){
        // Hide Household # for Single
        householdNumberWrapper.slideUp(300);
        $("#add_household_number").val('');
      } else if(civilStatus == 'Married' || civilStatus == 'Widowed' || civilStatus == 'Separated' || civilStatus == 'Annulled / Divorced'){
        // Show Household # for Married, Widowed, Separated, or Annulled/Divorced
        householdNumberWrapper.slideDown(300);
      } else {
        // Hide for empty
        householdNumberWrapper.slideUp(300);
        $("#add_household_number").val('');
      }
      
      // Handle Contact Number field visibility based on Civil Status
      var contactNumberDiv = $("#contact_number_div");
      if(civilStatus == 'Single'){
        // Show Contact Number for Single
        contactNumberDiv.slideDown(300);
        $("#add_contact_number").prop('required', true);
      } else if(civilStatus == 'Married' || civilStatus == 'Widowed' || civilStatus == 'Separated' || civilStatus == 'Annulled / Divorced'){
        // Hide Contact Number for Married, Widowed, Separated, or Annulled/Divorced
        contactNumberDiv.slideUp(300);
        $("#add_contact_number").prop('required', false).val('');
      } else {
        // Hide for empty
        contactNumberDiv.slideUp(300);
        $("#add_contact_number").prop('required', false).val('');
      }
      
      // Handle Contact Number of the Family field visibility based on Civil Status
      var familyNumberWrapper = $("#family_number_wrapper");
      if(civilStatus == 'Single'){
        // Hide Contact Number of the Family for Single
        familyNumberWrapper.slideUp(300);
        $("#add_family_number").prop('required', false).val('');
      } else if(civilStatus == 'Married' || civilStatus == 'Widowed' || civilStatus == 'Separated' || civilStatus == 'Annulled / Divorced'){
        // Show Contact Number of the Family for Married, Widowed, Separated, or Annulled/Divorced
        familyNumberWrapper.slideDown(300);
        $("#add_family_number").prop('required', true);
      } else {
        // Hide for empty
        familyNumberWrapper.slideUp(300);
        $("#add_family_number").prop('required', false).val('');
         $("#add_spouse_beneficiary_others").val('').hide();
        $("input[name='spouse_beneficiary[]']").prop('checked', false);
      }
    });

    // Show/hide custom IP Group input when "Other" is selected
    // Handle IP Group "Other" option in Family Profile
    $("#add_family_tribe").change(function(){
      var tribe_selected = $(this).val();
      
      if(tribe_selected == 'Others'){
        $("#custom_family_tribe_div").css('display', 'block');
        $("#add_custom_family_tribe").prop('required', true);
      }else{
        $("#custom_family_tribe_div").css('display', 'none');
        $("#add_custom_family_tribe").prop('required', false);
        $("#add_custom_family_tribe").val(''); // Clear the custom input
      }
    });

    // Handle Spouse IP Group "Others" option
    $("#add_spouse_ip_group").change(function(){
      var spouse_ip_group_selected = $(this).val();
      
      if(spouse_ip_group_selected == 'Others'){
        $("#custom_spouse_ip_group_div").css('display', 'block');
        $("#add_custom_spouse_ip_group").prop('required', true);
      } else {
        $("#custom_spouse_ip_group_div").css('display', 'none');
        $("#add_custom_spouse_ip_group").prop('required', false).val('');
      }
    });
 $(function () {
        $.validator.setDefaults({
          submitHandler: function (form) {
            // Check if all form sections are completed
            var accountFilled = $('#add_username').val() && $('#add_password').val() && $('#add_confirm_password').val();
            
            console.log('Form Validation Check:');
            console.log('Account Complete:', accountFilled);
            
            if (!accountFilled) {
              // Create navigation buttons for incomplete sections
              var navigationButtons = '';
              if (!accountFilled) {
                navigationButtons += '<button type="button" class="btn btn-primary btn-sm me-2 mb-2" onclick="navigateToTab(\'account-tab\')"><i class="fas fa-key"></i> Go to Account</button>';
              }

              Swal.fire({
                title: '<div style="color: #d32f2f; font-size: 24px;"><i class="fas fa-exclamation-triangle"></i> INCOMPLETE REGISTRATION</div>',
                html: '<div style="text-align: left; font-size: 16px; line-height: 1.6;">' +
                      '<div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 20px;">' +
                      '<strong style="color: #856404;">⚠️ Please complete ALL form sections before registering!</strong><br>' +
                      '<span style="color: #856404; font-size: 14px;">You need to fill out information in all tabs to successfully create your account.</span>' +
                      '</div>' +
                      '<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">' +
                      '<h6 style="color: #495057; margin-bottom: 15px; font-weight: 600;">📋 Registration Checklist:</h6>' +
                      '<div style="margin-left: 10px;">' +
                      '<div style="margin-bottom: 8px; padding: 8px; border-radius: 5px; background: ' + (accountFilled ? '#d4edda' : '#f8d7da') + ';">' +
                      '<i class="fas fa-' + (accountFilled ? 'check-circle' : 'times-circle') + '" style="color: ' + (accountFilled ? '#28a745' : '#dc3545') + '; margin-right: 8px;"></i>' +
                      '<strong style="color: ' + (accountFilled ? '#155724' : '#721c24') + ';">Account:</strong> ' + (accountFilled ? '✓ Complete' : '❌ Missing Username, Password, Confirm Password') +
                      '</div>' +
                      '</div>' +
                      '</div>' +
                      '<div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 15px; border-left: 4px solid #2196f3;">' +
                      '<h6 style="color: #0d47a1; margin-bottom: 10px; font-weight: 600;"><i class="fas fa-mouse-pointer"></i> Quick Navigation:</h6>' +
                      '<div style="text-align: center;">' + navigationButtons + '</div>' +
                      '<p style="color: #1565c0; font-size: 12px; margin-top: 10px; margin-bottom: 0;"><i class="fas fa-info-circle"></i> Click any button above to go directly to that form section</p>' +
                      '</div>' +
                      '</div>',
                width: '650px',
                confirmButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times"></i> Close',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                  popup: 'swal-wide'
                }
              });
              return false;
            }

            $.ajax({
                    url: 'signup/addResidence.php',
                    type: 'POST',
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    success:function(data){
                      // Trim whitespace
                      data = data.trim();

                      if(data == 'errorPassword'){
                          Swal.fire({
                            title: '<strong class="text-danger">ERROR</strong>',
                            type: 'error',
                            html: '<b>Password not Match<b>',
                            width: '400px',
                            confirmButtonColor: '#6610f2',
                          })
                      }else if(data == 'errorUsername'){

                        Swal.fire({
                            title: '<strong class="text-danger">ERROR</strong>',
                            type: 'error',
                            html: '<b>Username is Already Taken</b><br><small>Please choose a different username.</small>',
                            width: '400px',
                            confirmButtonColor: '#6610f2',
                          })
                      }else if(data == 'errorDuplicateName'){

                        Swal.fire({
                            title: '<strong class="text-danger">ERROR</strong>',
                            type: 'error',
                            html: '<b>Duplicate Name Detected</b><br><small>A person with the same Surname, First Name, and Middle Name already exists in the system. Please verify your information or contact the administrator.</small>',
                            width: '500px',
                            confirmButtonColor: '#6610f2',
                          })

                      }else if(data.indexOf('error:') === 0){
                        // Database or other error
                        var errorMsg = data.replace('error: ', '');
                        Swal.fire({
                            title: '<strong class="text-danger">ERROR</strong>',
                            type: 'error',
                            html: '<b>Registration Failed:</b><br>' + errorMsg + '<br><br><small>Please check if the registration_requests table exists in the database.</small>',
                            width: '500px',
                            confirmButtonColor: '#6610f2',
                          })

                      }else if(data == 'success' || data.trim() == ''){

                        Swal.fire({
                          title: '<strong class="text-success">REGISTRATION REQUEST SUBMITTED</strong>',
                          type: 'success',
                          html: '<div style="text-align: left; padding: 10px;">' +
                                '<p><b>Your registration request has been submitted successfully!</b></p>' +
                                '<p style="margin-top: 10px; color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;">' +
                                '<i class="fas fa-info-circle"></i> <strong>Pending Approval:</strong><br>' +
                                'Your account will be created after admin approval. ' +
                                'Please wait for the admin to review your registration request.</p>' +
                                '<p style="margin-top: 10px; font-size: 13px; color: #666;">' +
                                'You can check your registration status using your username. ' +
                                '<a href="checkRegistrationStatus.php" style="color: #667eea; font-weight: 600;">Check Status Here</a></p>' +
                                '</div>',
                          width: '500px',
                          confirmButtonColor: '#6610f2',
                          confirmButtonText: 'OK',
                          allowOutsideClick: false,
                        }).then(()=>{
                          window.location.href = 'login.php';
                        })
                      } else {
                        // Unknown response
                        console.log('Unknown response:', data);
                        Swal.fire({
                          title: '<strong class="text-warning">WARNING</strong>',
                          type: 'warning',
                          html: '<b>Unexpected response from server.</b><br>Response: ' + data,
                          width: '500px',
                          confirmButtonColor: '#6610f2',
                        })
                      }

                      
                    }
                }).fail(function(){
                    Swal.fire({
                      title: '<strong class="text-danger">Ooppss..</strong>',
                      type: 'error',
                      html: '<b>Something went wrong with ajax !<b>',
                      width: '400px',
                      confirmButtonColor: '#6610f2',
                    })
                })

           
          }
        });
      $('#registerResidentForm').validate({
       ignore:'',
        rules: {
          add_first_name: {
            required: true,
            minlength: 2
          },
          add_last_name: {
            required: true,
            minlength: 2
          },
          add_birth_date: {
            required: true,
          },
          add_birth_place: {
            required: true,
          },
          add_gender: {
            required: true,
          },
          add_civil_status: {
            required: true,
          },
          add_ip_status: {
            required: true,
          },
          add_family_surname: {
            required: true,
            minlength: 2
          },
          add_family_first_name: {
            required: true,
            minlength: 2
          },
          add_family_tribe: {
            required: true,
          },
          add_custom_family_tribe: {
            required: function() {
              return $('#add_family_tribe').val() === 'Others';
            }
          },
          add_family_religion: {
            required: true,
          },
          add_sitio_purok: {
            required: true,
          },
          add_place_of_origin: {
            required: true,
          },
          add_registered_civil_registry: {
            required: true,
          },
          add_contact_number: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Single';
            },
            pattern: /^09\d{9}$/
          },
          add_family_number: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            },
            pattern: /^09\d{9}$/
          },
          add_spouse_surname: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            },
            minlength: 2
          },
          add_spouse_first_name: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            },
            minlength: 2
          },
          add_spouse_sex: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            }
          },
          add_spouse_birthday: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            }
          },
          add_spouse_ip_group: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            }
          },
          add_custom_spouse_ip_group: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return (civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced') && $('#add_spouse_ip_group').val() === 'Others';
            }
          },
          add_spouse_place_of_origin: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            }
          },
          add_spouse_registered_civil_registry: {
            required: function() {
              var civilStatus = $('#add_civil_status').val();
              return civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced';
            }
          },
          add_username:{
            required: true,
            minlength: 8
          },
          add_password:{
            required: true,
            minlength: 8
          },
          add_confirm_password:{
            required: true,
            minlength: 8
          },
          add_pwd_info:{
            required: function() {
              return $('#add_pwd').is(':checked');
            }
          },
          add_image_residence: {
            imageRequired: true,
          },
        },
        messages: {
          add_image_residence: {
            imageRequired: "Please upload a profile picture"
          },
          add_first_name: {
            required: "This Field is required",
            minlength: "First Name must be at least 2 characters long"
          },
          add_last_name: {
            required: "This Field is required",
            minlength: "Last Name must be at least 2 characters long"
          },
        
            add_birth_date: {
            required: "This Field is required",
          },
          add_birth_place: {
            required: "This Field is required",
          },
          add_gender: {
            required: "This Field is required",
          },
          add_civil_status: {
            required: "This Field is required",
          },
          add_ip_status: {
            required: "This Field is required",
          },
          add_family_surname: {
            required: "This Field is required",
            minlength: "Surname must be at least 2 characters long"
          },
          add_family_first_name: {
            required: "This Field is required",
            minlength: "First Name must be at least 2 characters long"
          },
          add_family_tribe: {
            required: "This Field is required",
          },
          add_custom_family_tribe: {
            required: "Please specify the IP Group"
          },
          add_family_religion: {
            required: "This Field is required",
          },
          add_sitio_purok: {
            required: "This Field is required",
          },
          add_place_of_origin: {
            required: "This Field is required",
          },
          add_registered_civil_registry: {
            required: "This Field is required",
          },
          add_contact_number: {
            required: "Contact Number is required",
            pattern: "Please enter a valid contact number (e.g., 09111111111)"
          },
          add_family_number: {
            required: "Contact Number of the Family is required",
            pattern: "Please enter a valid contact number (e.g., 09111111111)"
          },
          add_spouse_surname: {
            required: "This Field is required",
            minlength: "Surname must be at least 2 characters long"
          },
          add_spouse_first_name: {
            required: "This Field is required",
            minlength: "First Name must be at least 2 characters long"
          },
          add_spouse_sex: {
            required: "This Field is required"
          },
          add_spouse_birthday: {
            required: "This Field is required"
          },
          add_spouse_ip_group: {
            required: "This Field is required"
          },
          add_custom_spouse_ip_group: {
            required: "Please specify the IP Group"
          },
          add_spouse_place_of_origin: {
            required: "This Field is required"
          },
          add_spouse_registered_civil_registry: {
            required: "This Field is required"
          },
          add_username: {
            required: "This Field is required",
            minlength: "Username must be at least 8 characters long"
          },
          add_password: {
            required: "This Field is required",
            minlength: "Password must be at least 8 characters long"
          },
          add_confirm_password: {
            required: "This Field is required",
            minlength: "Confirm Password must be at least 8 characters long"
          },
          add_pwd_info: {
            required: "Please specify the type of PWD"
          },
            
        },
   
     
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          // Special handling for image field
          if (element.attr('id') === 'add_image_residence') {
            error.insertAfter('#image_residence');
          } else {
            element.closest('.form-group').append(error);
          }
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
      
      });
      
    })







$("#show_hide_password span").on('click', function(event) {
      event.preventDefault();
      if($('#show_hide_password input').attr("type") == "text"){
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass("fa-eye-slash");
        $('#show_hide_password i').removeClass("fa-eye");
      }else if($('#show_hide_password input').attr("type") == "password"){
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass("fa-eye-slash");
        $('#show_hide_password i').addClass("fa-eye");
      }
    });

    $("#show_hide_password_confirm span").on('click', function(event) {
      event.preventDefault();
      if($('#show_hide_password_confirm input').attr("type") == "text"){
        $('#show_hide_password_confirm input').attr('type', 'password');
        $('#show_hide_password_confirm i').addClass("fa-eye-slash");
        $('#show_hide_password_confirm i').removeClass("fa-eye");
      }else if($('#show_hide_password_confirm input').attr("type") == "password"){
        $('#show_hide_password_confirm input').attr('type', 'text');
        $('#show_hide_password_confirm i').removeClass("fa-eye-slash");
        $('#show_hide_password_confirm i').addClass("fa-eye");
      }
    });

    $("#image_residence").click(function(){
          $("#add_image_residence").click();
      });


      function displayImge(input){
      if(input.files && input.files[0]){
        var reader = new FileReader();
        var add_image = $("#add_image_residence").val().split('.').pop().toLowerCase();

        if(add_image != ''){
          if(jQuery.inArray(add_image,['gif','png','jpg','jpeg']) == -1){
            Swal.fire({
              title: '<strong class="text-danger">ERROR</strong>',
              type: 'error',
              html: '<b>Invalid Image File<b>',
              width: '400px',
              confirmButtonColor: '#6610f2',
            })
            $("#add_image_residence").val('');
            $("#image_residence").attr('src', 'assets/dist/img/blank_image.png');
            return false;
          }
        }

        reader.onload = function(e){
          $("#image_residence").attr('src',e.target.result);
          $("#image_residence").hide();
          $("#image_residence").fadeIn(650);
        }

        reader.readAsDataURL(input.files[0]);

      }
    }  

    $("#add_image_residence").change(function(){
      displayImge(this);
      // Remove validation error when image is selected
      $(this).removeClass('is-invalid');
      $(this).closest('.profile-section').find('.invalid-feedback').remove();
      // Hide required text when image is uploaded
      if(this.files && this.files.length > 0){
        $("#image_required_text").hide();
        $("#image_residence").css('border', '');
      }
    })
    
    // Custom validation for image file
    $.validator.addMethod("imageRequired", function(value, element) {
      return this.optional(element) || (element.files && element.files.length > 0);
    }, "Please upload a profile picture");
    
    // Show required text on form submit if no image
    $("#registerResidentForm").on('submit', function(e){
      if(!$("#add_image_residence")[0].files || $("#add_image_residence")[0].files.length === 0){
        $("#image_required_text").show().css('color', '#dc3545');
        $("#image_residence").css('border', '3px solid #dc3545');
      } else {
        $("#image_required_text").hide();
        $("#image_residence").css('border', '');
      }
    });




  });

</script>

<script>
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));

 
  $("#add_zip, #add_age, #add_spouse_age, #add_household_number").inputFilter(function(value) {
  return /^-?\d*$/.test(value); 
  
  });

  // Contact Number of the Family input filter - only allow digits, max 11 digits (phone number format)
  $("#add_family_number").inputFilter(function(value) {
    // Only allow digits, max 11 digits (for phone numbers like 09111111111)
    if (value.length > 11) return false;
    return /^\d*$/.test(value);
  });
  
  // Input filter for Contact Number - only allow 11 digits starting with 09
  $("#add_contact_number").inputFilter(function(value) {
    // Only allow digits, max 11 digits (for phone numbers like 09111111111)
    if (value.length > 11) return false;
    return /^\d*$/.test(value);
  });
  


  $("#add_first_name, #add_middle_name, #add_last_name, #add_religion, #add_nationality, #add_family_surname, #add_family_first_name, #add_family_middle_name, #add_family_religion, #add_custom_family_tribe, #add_spouse_surname, #add_spouse_first_name, #add_spouse_middle_name, #add_place_of_origin, #add_spouse_place_of_origin, #add_custom_spouse_ip_group").inputFilter(function(value) {
  return /^[a-z, ]*$/i.test(value); 
  });
  
  $("#add_birth_place").inputFilter(function(value) {
  return /^[0-9a-z, ,-]*$/i.test(value); 
  });


  // Function to check form completion status
  function checkFormStatus() {
    // Check Profile Information required fields (basic fields)
    var basicFieldsFilled = 
      $('#add_birth_date').val() && 
      $('#add_birth_place').val() && 
      $('#add_gender').val() && 
      $('#add_civil_status').val() && 
      $('#add_ip_status').val() &&
      $('#add_family_surname').val() && 
      $('#add_family_first_name').val() && 
      $('#add_family_tribe').val() && 
        ($('#add_family_tribe').val() !== 'Others' || $('#add_custom_family_tribe').val()) &&
      $('#add_family_religion').val() && 
      $('#add_sitio_purok').val() && 
      $('#add_place_of_origin').val() && 
      $('#add_registered_civil_registry').val();
    
    // Check Contact Number based on Civil Status
    var civilStatus = $('#add_civil_status').val();
    var contactNumberFilled = true; // Default to true
    var familyNumberFilled = true; // Default to true
    
    if (civilStatus === 'Single') {
      // For Single, check Contact Number
      var contactNumber = $('#add_contact_number').val();
      var phonePattern = /^09\d{9}$/;
      contactNumberFilled = contactNumber && phonePattern.test(contactNumber);
    } else if (civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced') {
      // For Married/Widowed/Separated/Annulled, check Contact Number of the Family
      var familyNumber = $('#add_family_number').val();
      var phonePattern = /^09\d{9}$/;
      familyNumberFilled = familyNumber && phonePattern.test(familyNumber);
    }
    
    // Check spouse information based on Civil Status
    var spouseFieldsFilled = true; // Default to true (not required)
    
    if (civilStatus === 'Married' || civilStatus === 'Widowed' || civilStatus === 'Separated' || civilStatus === 'Annulled / Divorced') {
      // Spouse information is REQUIRED for Married, Widowed, Separated, or Annulled/Divorced
      spouseFieldsFilled = 
        $('#add_spouse_surname').val() && 
        $('#add_spouse_first_name').val() && 
        $('#add_spouse_sex').val() && 
        $('#add_spouse_birthday').val() && 
        $('#add_spouse_ip_group').val() && 
        ($('#add_spouse_ip_group').val() !== 'Others' || $('#add_custom_spouse_ip_group').val()) &&
        $('#add_spouse_place_of_origin').val() && 
        $('#add_spouse_registered_civil_registry').val();
    } else {
      // Single or empty - spouse information not required
      spouseFieldsFilled = true;
    }
    
    // Profile Information is complete if basic fields, contact number (if Single), family number (if applicable), and spouse fields (if applicable) are filled
    var familyProfileFilled = basicFieldsFilled && contactNumberFilled && familyNumberFilled && spouseFieldsFilled;
    
    // Check Account Information required fields
    var accountFilled = $('#add_username').val() && $('#add_password').val() && $('#add_confirm_password').val();
    
    // Update status indicators
    updateStatusIndicator('familyProfileStatus', familyProfileFilled, 'Profile Information');
    updateStatusIndicator('accountStatus', accountFilled, 'Account Information');
    
    return { familyProfileFilled, accountFilled };
  }
  
  // Function to update status indicator
  function updateStatusIndicator(elementId, isComplete, sectionName) {
    var element = $('#' + elementId);
    if (isComplete) {
      element.html('<i class="fas fa-check-circle me-1" style="color: #28a745;"></i>' + sectionName + ' <span style="color: #28a745;">✓</span>');
      element.css('color', '#28a745');
    } else {
      element.html('<i class="fas fa-times-circle me-1" style="color: #dc3545;"></i>' + sectionName + ' <span style="color: #dc3545;">✗</span>');
      element.css('color', '#dc3545');
    }
  }
  

  // Function to navigate to specific tabs
  function navigateToTab(tabId) {
    // Close the SweetAlert popup first
    Swal.close();
    
    // Remove active class from all tabs
    $('.nav-link').removeClass('active');
    $('.tab-pane').removeClass('active show');
    
    // Add active class to the target tab
    $('#' + tabId).addClass('active');
    
    // Show the corresponding tab content
    var targetContent = tabId.replace('-tab', '');
    $('#' + targetContent).addClass('active show');
    
    // Scroll to the form section
    $('html, body').animate({
      scrollTop: $('.form-section').offset().top - 100
    }, 500);
    
    // Highlight the tab briefly
    $('#' + tabId).css('background-color', '#fff3cd');
    setTimeout(function() {
      $('#' + tabId).css('background-color', '');
    }, 2000);
  }
  
  
  // Handle "Others" beneficiary checkbox
  $("#beneficiary_others").change(function() {
    if($(this).is(':checked')) {
      $("#add_beneficiary_others").show();
    } else {
      $("#add_beneficiary_others").hide();
      $("#add_beneficiary_others").val('');
    }
  });
  
  // Handle spouse "Others" beneficiary checkbox
  $("#spouse_beneficiary_others").change(function() {
    if($(this).is(':checked')) {
      $("#add_spouse_beneficiary_others").show();
    } else {
      $("#add_spouse_beneficiary_others").hide();
      $("#add_spouse_beneficiary_others").val('');
    }
  });
  
  // Real-time form validation on input change
  $('input, select').on('input change', function() {
    checkFormStatus();
  });
  
  // Add event listeners to all required fields to update progress in real-time
  $(document).ready(function() {
    // Profile Information basic fields
    $('#add_birth_date, #add_birth_place, #add_gender, #add_civil_status, #add_ip_status, #add_family_surname, #add_family_first_name, #add_family_tribe, #add_custom_family_tribe, #add_family_religion, #add_sitio_purok, #add_place_of_origin, #add_registered_civil_registry').on('change input keyup', function() {
      checkFormStatus();
    });
    
    // Spouse Information fields (will be checked conditionally based on Civil Status)
    $('#add_spouse_surname, #add_spouse_first_name, #add_spouse_sex, #add_spouse_birthday, #add_spouse_ip_group, #add_custom_spouse_ip_group, #add_spouse_place_of_origin, #add_spouse_registered_civil_registry').on('change input keyup', function() {
      checkFormStatus();
    });
    
    // Family # field (conditional based on Civil Status)
    $('#add_family_number').on('change input keyup', function() {
      checkFormStatus();
    });
    
    // Account Information fields
    $('#add_username, #add_password, #add_confirm_password').on('change input keyup', function() {
      checkFormStatus();
    });
    
    // Initial status check when page loads
    checkFormStatus();
    
    // Check voters checkbox on page load based on birth date
    var initialBirthDate = $("#add_birth_date").val();
    if(initialBirthDate){
      var today = new Date();
      var birth = new Date(initialBirthDate);
      var age = today.getFullYear() - birth.getFullYear();
      var monthDiff = today.getMonth() - birth.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
      }
      
      // Handle Voters checkbox based on age (must be 18 or above)
      if(age < 18){
        // Disable and uncheck Voters if below 18 years old
        $("#add_voters").prop('disabled', true);
        $("#add_voters").prop('checked', false);
        $("#add_voters").closest('.form-check').find('label').css('opacity', '0.6');
        $("#add_voters").css('cursor', 'not-allowed');
      } else {
        // Enable Voters if 18 years old or above
        $("#add_voters").prop('disabled', false);
        $("#add_voters").closest('.form-check').find('label').css('opacity', '1');
        $("#add_voters").css('cursor', 'pointer');
      }
    } else {
      // Disable Voters if no birth date
      $("#add_voters").prop('disabled', true);
      $("#add_voters").prop('checked', false);
      $("#add_voters").closest('.form-check').find('label').css('opacity', '0.6');
      $("#add_voters").css('cursor', 'not-allowed');
    }
  });

</script>

</body>
</html>

