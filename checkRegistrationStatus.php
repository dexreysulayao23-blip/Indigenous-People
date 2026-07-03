<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Check Registration Status - IPs Portal</title>
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/sweetalert2/css/sweetalert2.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #CD853F 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .status-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      padding: 40px;
      max-width: 600px;
      width: 100%;
    }
    .status-card h2 {
      color: #8B4513;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
    }
    .form-control {
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 15px;
      transition: all 0.3s ease;
    }
    .form-control:focus {
      border-color: #8B4513;
      box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    }
    .btn-check {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      color: white;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
    }
    .btn-check:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }
    .btn-back {
      background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      color: white;
      font-weight: 600;
      width: 100%;
      margin-top: 15px;
      transition: all 0.3s ease;
    }
    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
      color: white;
    }
    .status-result {
      margin-top: 30px;
      padding: 20px;
      border-radius: 10px;
      display: none;
    }
    .status-pending {
      background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
      border: 2px solid #ffc107;
      color: #856404;
    }
    .status-approved {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      border: 2px solid #28a745;
      color: #155724;
    }
    .status-rejected {
      background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
      border: 2px solid #dc3545;
      color: #721c24;
    }
  </style>
</head>
<body>

<div class="status-card">
  <h2><i class="fas fa-search"></i> Check Registration Status</h2>
  <form id="checkStatusForm">
    <div class="form-group">
      <label for="username"><i class="fas fa-user"></i> Username</label>
      <input type="text" class="form-control" id="username" name="username" required placeholder="Enter your username">
    </div>
    <button type="submit" class="btn btn-check">
      <i class="fas fa-search"></i> Check Status
    </button>
    <a href="login.php" class="btn btn-back">
      <i class="fas fa-arrow-left"></i> Back to Login
    </a>
  </form>
  
  <div id="statusResult" class="status-result">
    <h4><i class="fas fa-info-circle"></i> Registration Status</h4>
    <p id="statusMessage"></p>
  </div>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/sweetalert2/js/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function(){
  $('#checkStatusForm').submit(function(e){
    e.preventDefault();
    var username = $('#username').val();
    
    $.ajax({
      url: 'checkRegistrationStatusHandler.php',
      type: 'POST',
      data: {username: username},
      dataType: 'json',
      success: function(response){
        if(response.status == 'found'){
          var statusClass = 'status-' + response.request_status;
          var icon = '';
          var message = '';
          
          if(response.request_status == 'pending'){
            icon = '<i class="fas fa-clock fa-2x mb-2" style="color: #ffc107;"></i>';
            message = '<strong>Status: PENDING</strong><br>' +
                     'Your registration request is being reviewed by the admin.<br>' +
                     '<small>Request ID: ' + response.request_id + '</small><br>' +
                     '<small>Submitted: ' + response.date_requested + '</small>';
          } else if(response.request_status == 'approved'){
            icon = '<i class="fas fa-check-circle fa-2x mb-2" style="color: #28a745;"></i>';
            message = '<strong>Status: APPROVED</strong><br>' +
                     'Your registration has been approved! You can now login.<br>' +
                     '<small>Processed: ' + response.date_processed + '</small><br>' +
                     '<a href="login.php" class="btn btn-success btn-sm mt-2">Go to Login</a>';
          } else if(response.request_status == 'rejected'){
            icon = '<i class="fas fa-times-circle fa-2x mb-2" style="color: #dc3545;"></i>';
            message = '<strong>Status: REJECTED</strong><br>' +
                     'Your registration request has been rejected.<br>' +
                     (response.admin_notes ? '<strong>Reason:</strong> ' + response.admin_notes + '<br>' : '') +
                     '<small>You may register again with correct information.</small>';
          }
          
          $('#statusResult').removeClass('status-pending status-approved status-rejected')
                           .addClass(statusClass)
                           .html(icon + '<div>' + message + '</div>')
                           .fadeIn();
        } else {
          Swal.fire({
            icon: 'info',
            title: 'Not Found',
            text: response.message,
            confirmButtonColor: '#8B4513'
          });
          $('#statusResult').hide();
        }
      },
      error: function(){
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to check status. Please try again.',
          confirmButtonColor: '#8B4513'
        });
      }
    });
  });
});
</script>
</body>
</html>

