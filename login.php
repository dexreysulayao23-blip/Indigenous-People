
<?php 
include_once 'connection.php';
session_start();

try{

  if(isset($_SESSION['user_id']) && $_SESSION['user_type']){


  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE id = ?";
  $query = $con->prepare($sql) or die ($con->error);
  $query->bind_param('s', $user_id);
  $query->execute();
  $result = $query->get_result();
  $row = $result->fetch_assoc();
  
  // Check if user exists
  if ($row) {
    $account_type = $row['user_type'];
  } else {
    // User not found, redirect to login
    session_destroy();
    echo '<script>window.location.href="login.php";</script>';
    exit;
  }
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
  
  // Initialize variables with default values
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
      
      // Check if image file exists, if not use default
      if (!empty($image) && file_exists('assets/dist/img/' . $image)) {
          $image = $row['image'];
          $image_path = $row['image_path'];
      } else {
          $image = 'logo.png'; // Use default logo if image doesn't exist
          $image_path = 'assets/dist/img/logo.png';
      }
      
      // Get background image from database - SAME LOGIC AS admin/settings.php
      $background_image = isset($row['background_image']) ? trim($row['background_image']) : '';
      $background_image_path = isset($row['background_image_path']) && !empty(trim($row['background_image_path'])) ? trim($row['background_image_path']) : '../assets/logo/cover.jpg';
      
      // Remove '../' prefix for public pages (for display)
      $background_image_path_display = str_replace('../', '', $background_image_path);
      
      // Get absolute path for file checking (same as admin/settings.php)
      $script_dir = dirname(__FILE__);
      $base_dir = $script_dir; // login.php is in root, so no need to go up
      
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

}catch(Exception $e){
  echo $e->getMessage();
}







?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPs Portal - Login</title>
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/sweetalert2/css/sweetalert2.min.css">
 

  <style>
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
    .content-wrapper{
      background-image: url('<?= $background_image_path_display ?>');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .content-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(139, 69, 19, 0.1) 0%, rgba(160, 82, 45, 0.05) 100%);
      z-index: 1;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(15px);
      padding: 40px;
      margin: 0 auto;
      max-width: 400px;
      width: 100%;
      position: relative;
      overflow: hidden;
      z-index: 2;
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #8B4513 0%, #A0522D 100%);
    }

    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 4px solid #8B4513;
      box-shadow: 0 8px 20px rgba(139, 69, 19, 0.3);
      margin: 0 auto 20px;
      display: block;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .login-logo:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 12px 24px rgba(139, 69, 19, 0.4);
    }

    .login-title {
      font-size: 2rem;
      font-weight: 700;
      margin: 0 0 10px 0;
      color: #2d3748;
      letter-spacing: -0.01em;
    }

    .login-subtitle {
      color: #4a5568;
      font-size: 1rem;
      margin: 0 0 30px 0;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: white;
      color: #2d3748;
    }

    .form-control:focus {
      border-color: #8B4513;
      box-shadow: 0 0 0 2px rgba(139, 69, 19, 0.1);
      background: white;
      color: #2d3748;
    }

    .input-group {
      display: flex;
      align-items: stretch;
      position: relative;
      height: 48px;
    }

    .input-group .form-control {
      border-left: none;
      border-radius: 0 10px 10px 0;
      height: 48px;
      padding: 12px 16px;
    }

    .input-group .form-control:focus {
      border-left: none;
      border-radius: 0 10px 10px 0;
      height: 48px;
    }

    .input-group .input-group-text {
      border-right: none;
      border-radius: 10px 0 0 10px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .input-group-text {
      background: #8B4513;
      color: white;
      border: 2px solid #8B4513;
      border-radius: 10px 0 0 10px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 50px;
      height: 48px;
      border-right: none;
    }

    .btn-login {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-size: 14px;
      font-weight: 600;
      color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      width: 100%;
      box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-login:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(102, 126, 234, 0.4);
    }

    .btn-back {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 16px;
      font-size: 12px;
      font-weight: 500;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 2px 8px rgba(139, 69, 19, 0.3);
    }

    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(139, 69, 19, 0.4);
      color: white;
      text-decoration: none;
    }
    
    .btn-back {
      margin-right: 1.5rem !important;
    }

    .btn-back:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.2);
    }

    .navbar {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%) !important;
      box-shadow: 0 4px 20px rgba(139, 69, 19, 0.3);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: -0.01em;
      color: white !important;
    }

    .nav-link {
      color: white !important;
      font-weight: 500;
      transition: all 0.3s ease;
      border-radius: 8px;
      margin: 0 4px;
      padding: 8px 16px;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    .rightBar:hover {
      border-bottom: 3px solid #f4e4bc;
    }

    .forgot-password {
      color: #8B4513;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .forgot-password:hover {
      color: #A0522D;
      text-decoration: none;
    }

    .btn-signup {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 3px 12px rgba(139, 69, 19, 0.3);
    }

    .btn-signup:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(139, 69, 19, 0.4);
      color: white;
      text-decoration: none;
    }

    .btn-signup:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .login-container {
        margin: 20px;
        padding: 30px 20px;
      }
      
      .login-title {
        font-size: 1.5rem;
      }
    }


@keyframes example {
  from {opacity: 0;}
  to {opacity: 1.5;}
}

/* Custom styling for Account Inactive modal */
.swal2-popup-custom {
  border-radius: 15px !important;
  box-shadow: 0 10px 40px rgba(0,0,0,0.3) !important;
}

.swal2-title-custom {
  color: #dc3545 !important;
  font-weight: 700 !important;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.1) !important;
  padding: 20px 0 10px 0 !important;
}

.swal2-html-container-custom {
  padding: 10px 20px 20px 20px !important;
  text-align: left !important;
}

.swal2-html-container-custom p {
  color: #333 !important;
  font-size: 16px !important;
  line-height: 1.6 !important;
}

.swal2-html-container-custom strong {
  color: #333 !important;
  font-weight: 700 !important;
}





  </style>


</head>
<body  class="hold-transition layout-top-nav">


<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar">
    <div class="container-fluid">
      <a href="" class="navbar-brand">
        <?php 
        $logo_path = 'assets/dist/img/' . $image;
        if (!empty($image) && file_exists($logo_path)) {
            echo '<img src="' . $logo_path . '" alt="logo" class="brand-image img-circle">';
        } else {
            echo '<img src="assets/dist/img/logo.png" alt="logo" class="brand-image img-circle">';
        }
        ?>
        <span class="brand-text  text-white" style="font-weight: 700">IPs PORTAL</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->


       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" style="margin-right: 0 !important;">
        <li class="nav-item">
          <a href="checkRegistrationStatus.php" class="nav-link" style="background: rgba(255, 255, 255, 0.2); border-radius: 8px; margin-right: 0;">
            <i class="fas fa-search"></i> Check Registration Status
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
 
    
  
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content-wrapper">
      <div class="login-container">
        <div class="login-header">
          <?php 
          $logo_path = 'assets/dist/img/' . $image;
          if (!empty($image) && file_exists($logo_path)) {
              echo '<img src="' . $logo_path . '" alt="logo" class="login-logo">';
          } else {
              echo '<img src="assets/dist/img/logo.png" alt="logo" class="login-logo">';
          }
          ?>
          <h1 class="login-title">Login</h1>
          <p class="login-subtitle">Enter your credentials to access your account</p>
        </div>
        
        <form id="loginForm" method="post">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-text">
                <i class="fas fa-user"></i>
              </div>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username or Resident Number">
            </div>
          </div>
          
          <div class="form-group">
            <div class="input-group" id="show_hide_password">
              <div class="input-group-text">
                <i class="fas fa-lock"></i>
              </div>
              <input type="password" id="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <span class="input-group-text" style="background: #667eea; color: white; border: 2px solid #667eea; border-left: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                  <i class="fas fa-eye-slash" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
          
          <div class="form-group d-flex justify-content-center align-items-center">
            <button type="button" onclick="window.location.href='index.php'" class="btn btn-back me-5">
              <i class="fas fa-arrow-left"></i> Back to Dashboard
            </button>
            <a href="forgot.php" class="forgot-password">Forgot Password?</a>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-login">
              <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
          </div>
          
          <div class="form-group text-center">
            <p class="mb-2" style="color: #4a5568; font-size: 14px;">Don't have an account?</p>
            <a href="register.php" class="btn btn-signup">
              <i class="fas fa-user-plus"></i> Sign Up
            </a>
          </div>
        </form>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 

 


</div>
<!-- ./wrapper -->
<footer class="main-footer text-white" style="background-color: #0037af">
    <div class="float-right d-none d-sm-block">
    
    </div>
  <i class="fas fa-map-marker-alt"></i> <?= $postal_address ?> 
  </footer>




<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>
<script src="assets/plugins/sweetalert2/js/sweetalert2.all.min.js"></script>

<script>
  $(document).ready(function() {


    $("#loginForm").submit(function(e){
      e.preventDefault();
      var username = $("#username").val();
      var password = $("#password").val();
      if(username == '' || password == ''){
        Swal.fire({
          title: '<strong class="text-danger">WARNING</strong>',
          type: 'warning',
          html: '<b>Username and Password is Required<b>',
          width: '400px',
        })
      }else{
        $.ajax({
          url: 'loginForm.php',
          type: 'POST',
          data: $(this).serialize(),
          success:function(data){
              if(data == 'errorUsername'){
                Swal.fire({
                  title: '<strong class="text-danger">ERROR</strong>',
                  type: 'error',
                  html: '<b>Incorrect Username or Password<b>',
                  width: '400px',
                })
              }else if(data =='errorPassword'){
                Swal.fire({
                  title: '<strong class="text-danger">ERROR</strong>',
                  type: 'error',
                  html: '<b>Incorrect Username or Password<b>',
                  width: '400px',
                })
              }else if(data.indexOf('accountInactive') === 0){
                // Check if reason is included
                var reasonHtml = '<div style="text-align: left; padding: 10px 0;">' +
                                 '<p style="color: #333; font-size: 16px; font-weight: 600; margin-bottom: 15px; line-height: 1.5;">Your account has been deactivated. Please contact the administrator.</p>' +
                                 '</div>';
                if(data.indexOf('|') > 0){
                  var reason = atob(data.split('|')[1]);
                  reasonHtml = '<div style="text-align: left; padding: 10px 0;">' +
                               '<p style="color: #333; font-size: 16px; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">Your account has been deactivated.</p>' +
                               '<div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); padding: 20px; border-radius: 10px; border: 2px solid #ffc107; margin-top: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">' +
                               '<div style="display: flex; align-items: center; margin-bottom: 10px;">' +
                               '<i class="fas fa-info-circle" style="color: #856404; font-size: 20px; margin-right: 10px;"></i>' +
                               '<strong style="color: #856404; font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Reason:</strong>' +
                               '</div>' +
                               '<div style="background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-top: 10px;">' +
                               '<p style="color: #333; margin: 0; font-size: 15px; font-weight: 500; line-height: 1.6; word-wrap: break-word;">' + reason + '</p>' +
                               '</div>' +
                               '</div>' +
                               '<p style="color: #666; font-size: 13px; margin-top: 15px; font-style: italic;">Please contact the administrator if you have any questions.</p>' +
                               '</div>';
                }
                Swal.fire({
                  title: '<strong style="font-size: 24px; letter-spacing: 1px; color: #dc3545;">ACCOUNT INACTIVE</strong>',
                  type: 'error',
                  html: reasonHtml,
                  width: '550px',
                  confirmButtonColor: '#6610f2',
                  confirmButtonText: 'OK',
                  allowOutsideClick: false,
                  allowEscapeKey: true
                }).then(function() {
                  // Add custom styling after modal opens
                  setTimeout(function() {
                    var popup = document.querySelector('.swal2-popup');
                    var title = document.querySelector('.swal2-title');
                    var htmlContainer = document.querySelector('.swal2-html-container');
                    if(popup) {
                      popup.style.borderRadius = '15px';
                      popup.style.boxShadow = '0 10px 40px rgba(0,0,0,0.3)';
                    }
                    if(title) {
                      title.style.color = '#dc3545';
                      title.style.fontWeight = '700';
                      title.style.textShadow = '1px 1px 2px rgba(0,0,0,0.1)';
                      title.style.padding = '20px 0 10px 0';
                    }
                    if(htmlContainer) {
                      htmlContainer.style.padding = '10px 20px 20px 20px';
                      htmlContainer.style.textAlign = 'left';
                    }
                  }, 100);
                })
              }else if(data == 'admin'){
                Swal.fire({
                  title: '<strong class="text-success">SUCCESS</strong>',
                  type: 'success',
                  html: '<b>Login Successfully<b>',
                  width: '400px',
                  showConfirmButton:  false,
                  allowOutsideClick: false,
                  timer: 2000
                }).then(()=>{
                  window.location.href = 'admin/dashboard.php';
                })
              }else if(data == 'resident'){
                Swal.fire({
                  title: '<strong class="text-success">SUCCESS</strong>',
                  type: 'success',
                  html: '<b>Login Successfully<b>',
                  width: '400px',
                  showConfirmButton:  false,
                  allowOutsideClick: false,
                  timer: 2000
                }).then(()=>{
                  window.location.href = 'resident/dashboard.php';
                })
              }
          }
        })
      }
    })




    $("#show_hide_password .input-group-append span").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script>


</body>
</html>

