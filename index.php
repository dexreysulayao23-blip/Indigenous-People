

<?php
//index.php
include_once 'connection.php';
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_type']){


  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE id = ?";
  $query = $con->prepare($sql) or die ($con->error);
  $query->bind_param('s', $user_id);
  $query->execute();
  $result = $query->get_result();
  $row = $result->fetch_assoc();
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
  
  // Initialize variables with default values
  $IPs = 'IPs';
  $zone = 'Zone';
  $district = 'District';
  $image = 'default.png';
  $image_path = '../assets/dist/img/default.png';
  $id = '1';
  $postal_address = 'Postal Address';
  
  while($row = $result->fetch_assoc()){
      $IPs = $row['IPs'];
      $zone = $row['zone'];
      $district = $row['district'];
      $image = $row['image'];
      $image_path = $row['image_path'];
      $id = $row['id'];
      $postal_address = $row['postal_address'];
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
 

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
      background-image: url('assets/logo/cover.jpg');
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
      background: linear-gradient(135deg, rgba(139, 69, 19, 0.8) 0%, rgba(160, 82, 45, 0.7) 100%);
      z-index: 1;
    }

    .content {
      position: relative;
      z-index: 2;
      width: 100%;
    }

    .modern-hero {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 24px;
      box-shadow: 0 32px 64px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(20px);
      padding: 60px 40px;
      margin: 0 auto;
      max-width: 800px;
      width: 100%;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .modern-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #8B4513 0%, #A0522D 100%);
    }

    .hero-title {
      color: #2d3748;
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      letter-spacing: -0.02em;
    }

    .hero-logo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid #8B4513;
      box-shadow: 0 20px 40px rgba(139, 69, 19, 0.3);
      margin: 30px auto;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-logo:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 30px 60px rgba(139, 69, 19, 0.4);
    }

    .hero-subtitle {
      color: #4a5568;
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 40px;
      line-height: 1.4;
    }

    .btn-modern {
      display: inline-block;
      padding: 16px 32px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 12px;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      margin: 8px;
      position: relative;
      overflow: hidden;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(102, 126, 234, 0.4);
      color: white;
    }

    .btn-secondary {
      background: transparent;
      color: #8B4513;
      border: 2px solid #8B4513;
    }

    .btn-secondary:hover {
      background: #8B4513;
      color: white;
      transform: translateY(-4px);
      box-shadow: 0 16px 32px rgba(139, 69, 19, 0.2);
    }

    .navbar {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%) !important;
      box-shadow: 0 4px 20px rgba(139, 69, 19, 0.3);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: -0.01em;
    }

    .nav-link {
      transition: all 0.3s ease;
      border-radius: 8px;
      margin: 0 4px;
      font-weight: 500;
      padding: 8px 16px;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    .footer {
      background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
      color: white;
      text-align: center;
      padding: 30px;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    }

    .rightBar:hover {
      border-bottom: 3px solid #f4e4bc;
    }

    /* Features Section */
    .features-section {
      padding: 80px 0;
      background: rgba(255, 255, 255, 0.95);
      margin: 40px 0;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .features-title {
      color: #2d3748;
      font-size: 2.5rem;
      font-weight: 800;
      text-align: center;
      margin-bottom: 20px;
      letter-spacing: -0.02em;
    }

    .features-subtitle {
      color: #4a5568;
      font-size: 1.2rem;
      text-align: center;
      margin-bottom: 60px;
      font-weight: 500;
    }

    .features-grid {
      margin-top: 40px;
    }

    .feature-card {
      background: white;
      border-radius: 20px;
      padding: 40px 30px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      margin-bottom: 30px;
      border: 2px solid #f7fafc;
    }

    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
      border-color: #8B4513;
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      transition: all 0.3s ease;
    }

    .feature-icon i {
      font-size: 2rem;
      color: white;
    }

    .feature-card:hover .feature-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .feature-card h3 {
      color: #2d3748;
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 15px;
      letter-spacing: -0.01em;
    }

    .feature-card p {
      color: #4a5568;
      font-size: 14px;
      line-height: 1.6;
      margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .modern-hero {
        padding: 40px 20px;
        margin: 10px;
      }
      
      .hero-title {
        font-size: 2.5rem;
      }
      
      .hero-logo {
        width: 100px;
        height: 100px;
      }
      
      .hero-subtitle {
        font-size: 1.2rem;
      }
      
      .btn-modern {
        padding: 14px 24px;
        font-size: 14px;
        margin: 4px;
      }

      .features-section {
        padding: 40px 20px;
        margin: 20px 0;
      }

      .features-title {
        font-size: 2rem;
      }

      .feature-card {
        padding: 30px 20px;
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
        <img src="assets/dist/img/<?= $image  ?>" alt="logo" class="brand-image img-circle " >
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
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
 
    
  
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="modern-hero">
          <h1 class="hero-title">Welcome to IPs Portal</h1>
          <img src="assets/dist/img/<?= $image;?>" alt="logo" class="hero-logo">
          <h2 class="hero-subtitle"><?= $IPs ?> <?= $zone ?>, <?= $district ?></h2>
          <div class="mt-4">
            <a href="login.php" class="btn-modern btn-primary">Get Started</a>
          </div>
        </div>

        <!-- Features Section -->
        <div class="features-section">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="features-title">Services & Benefits</h2>
                <p class="features-subtitle">Services we offer and benefits you get from using this system</p>
              </div>
            </div>
            
            <div class="row features-grid">
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-certificate"></i>
                  </div>
                  <h3>Certificate Requests</h3>
                  <p>Request and track certificate status online anytime.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-user-check"></i>
                  </div>
                  <h3>Online Registration</h3>
                  <p>Register online without visiting the office.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-comments"></i>
                  </div>
                  <h3>Direct Messaging</h3>
                  <p>Contact admin directly for inquiries and follow-ups.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                  </div>
                  <h3>Status Tracking</h3>
                  <p>Check your request status in real-time.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-file-invoice"></i>
                  </div>
                  <h3>Digital Records</h3>
                  <p>Access your personal records anytime, anywhere.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                  </div>
                  <h3>Auto Notifications</h3>
                  <p>Get notified when your requests are approved.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                  </div>
                  <h3>24/7 Access</h3>
                  <p>Access the system anytime, anywhere.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                  </div>
                  <h3>Secure & Private</h3>
                  <p>Your personal information is secure and protected.</p>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                  <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                  </div>
                  <h3>Mobile-Friendly</h3>
                  <p>Works on mobile phones, tablets, and computers.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  



    

    <!-- <div class="container-fluid ">
      <div class="row pt-5">
        <div class="col-sm-7">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="4000">
                    <ol class="carousel-indicators">
                    <?php echo make_slide_indicators($con); ?>
          
                    </ol>
                <div class="carousel-inner">
                <?php echo make_slides($con); ?>
                  
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-custom-icon" aria-hidden="true">
                    <i class="fas fa-chevron-left"></i>
                  </span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-custom-icon" aria-hidden="true">
                    <i class="fas fa-chevron-right"></i>
                  </span>
                  <span class="sr-only">Next</span>
                </a>
              </div>

        </div>
        <div class="col-sm-5">
          <div class="card text-left">
            <img class="card-img-top" src="holder.js/100px180/" alt="">
            <div class="card-body">
              <h4 class="card-title">Title</h4>
              <p class="card-text">Body</p>
            </div>
          </div>
        </div>
      </div>
            
    </div> -->
 

     
          
               
      
     
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
  <footer class="main-footer text-white footer">
    <div class="float-right d-none d-sm-block">
    
    </div>
  <i class="fas fa-map-marker-alt"></i> <?= $postal_address ?> 
  </footer>
 


</div>
<!-- ./wrapper -->





<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>

</body>
</html>
