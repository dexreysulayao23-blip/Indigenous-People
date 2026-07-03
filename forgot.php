
<?php 
include_once 'connection.php';
session_start();

try{

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
      $base_dir = $script_dir; // forgot.php is in root, so no need to go up
      
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
  <title>IPs Portal - Forgot Password</title>
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
      background-position: center;
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .forgot-container {
      background: rgba(255, 255, 255, 0.98);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(15px);
      padding: 40px;
      margin: 0 auto;
      max-width: 450px;
      width: 100%;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .forgot-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .forgot-logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin: 0 auto 20px;
      display: block;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .forgot-title {
      font-size: 2rem;
      font-weight: 700;
      margin: 0 0 10px 0;
      color: #2d3748;
      letter-spacing: -0.01em;
    }

    .forgot-subtitle {
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
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: white;
      color: #2d3748;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
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
      background: #667eea;
      color: white;
      border: 2px solid #667eea;
      border-radius: 10px 0 0 10px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 50px;
      height: 48px;
      border-right: none;
    }

    .btn-recover {
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

    .btn-recover:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(102, 126, 234, 0.4);
    }

    .btn-back {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 12px;
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
      color: white !important;
    }

    .nav-link {
      color: white !important;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      color: #f4e4bc !important;
      transform: translateY(-2px);
    }

    .rightBar:hover {
      border-bottom: 3px solid #f4e4bc;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .forgot-container {
        margin: 20px;
        padding: 30px 20px;
      }
      
      .forgot-title {
        font-size: 1.5rem;
      }
    }


@keyframes example {
  from {opacity: 0;}
  to {opacity: 1.5;}
}





  </style>


</head>
<body  class="hold-transition layout-top-nav">


<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar">
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
        <span class="brand-text  text-white" style="font-weight: 700">IPs PORTAL</span>
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
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
 
    
  
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content-wrapper">
      <div class="forgot-container">
        <div class="forgot-header">
          <?php 
          $forgot_logo_path = 'assets/dist/img/' . $image;
          if (!empty($image) && file_exists($forgot_logo_path)) {
            $forgot_logo_src = $forgot_logo_path;
          } else {
            $forgot_logo_src = 'assets/dist/img/logo.png';
          }
          ?>
          <img src="<?= $forgot_logo_src ?>" alt="logo" class="forgot-logo">
          <h1 class="forgot-title">Forgot Password</h1>
          <p class="forgot-subtitle">Enter your username or resident number to recover your account</p>
        </div>
        
        <form id="recoverForm" method="post">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-text">
                <i class="fas fa-user"></i>
              </div>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username or Resident Number">
            </div>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-recover">
              <i class="fas fa-key"></i> Recover Account
            </button>
          </div>
          
          <div class="form-group text-center">
            <a href="login.php" class="btn btn-back">
              <i class="fas fa-arrow-left"></i> Back to Login
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





<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>
<script src="assets/plugins/sweetalert2/js/sweetalert2.all.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>
<div id="show_number"></div>

<script>
  $(document).ready(function(){



   



      $("#recoverForm").submit(function(e){
          e.preventDefault();
        var username = $("#username").val();

        $("#show_number").html('');
        
        if(username != ''){


    
          $.ajax({
            url: 'recoverAccount.php',
            type: 'POST',
            data:{username:username},
            cache: false,
            success:function(data){
              $("#show_number").html(data);
              $("#recoverModal").modal('show');

            }
          })
          
         

        }else{

          Swal.fire({
            title: '<strong class="text-warning">TYPE YOUR USERNAME</strong>',
            type: 'error',
            showConfirmButton: true,
          })

        }



      })
 


    
 



    


    


  })
</script>


</body>
</html>
