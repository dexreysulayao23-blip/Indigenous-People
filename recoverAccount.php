<?php 


include_once 'connection.php';

try{

  
  $username = $con->real_escape_string($_POST['username']);

  // Get user info and join with residence_information to get civil_status and family_number
  $sql = "SELECT u.contact_number, r.civil_status, r.family_number 
          FROM `users` u 
          LEFT JOIN `residence_information` r ON u.id = r.residence_id 
          WHERE (u.username = ? OR u.id = ?)";
  $stmt = $con->prepare($sql) or die ($con->error);
  $stmt->bind_param('ss',$username,$username);
  $stmt->execute();
  $result = $stmt->get_result();

  $count= $result->num_rows;
  
  // Determine which contact number to use based on civil status
  $contact_number_to_use = '';
  if($count > 0){
    $row = $result->fetch_assoc();
    $civil_status = isset($row['civil_status']) ? $row['civil_status'] : '';
    
    // If married, widowed, separated, or annulled/divorced, use family_number
    // Otherwise, use contact_number (for Single or if civil_status is not set)
    if($civil_status == 'Married' || $civil_status == 'Widowed' || $civil_status == 'Separated' || $civil_status == 'Annulled / Divorced'){
      $contact_number_to_use = isset($row['family_number']) && !empty($row['family_number']) ? $row['family_number'] : $row['contact_number'];
    } else {
      // For Single or if civil_status is not set, use contact_number
      $contact_number_to_use = $row['contact_number'];
    }
    
    // Update the result array to use the correct contact number
    $row['contact_number'] = $contact_number_to_use;
    
    // Re-execute query to get the updated row (or we can just use the modified $row)
    // Actually, we'll just use the modified $row variable
  }

  




}catch(Exception $e){
  echo $e->getMessage();
}










?>




<style>
/* Simple fix for input group alignment */
.input-group {
  display: flex !important;
  align-items: stretch !important;
  height: 38px !important;
  position: relative !important;
}

/* Ensure all input group elements have consistent height */
.input-group-prepend,
.input-group-append {
  display: flex !important;
  align-items: center !important;
  height: 38px !important;
}

.input-group-text {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 38px !important;
  border-radius: 0 !important;
}

.input-group .form-control {
  height: 38px !important;
  border-radius: 0 !important;
  border-left: none !important;
  border-right: none !important;
}

/* Specific positioning for confirm password input group */
#new_confirm_password {
  padding-right: 60px !important;
}

/* Ensure first input group (Last 4 Digits) has proper alignment */
.input-group:first-of-type .form-control {
  border-left: 1px solid #ced4da !important;
  border-top-left-radius: 0.25rem !important;
  border-bottom-left-radius: 0.25rem !important;
}

/* Ensure last input group elements have proper border radius */
.input-group:last-of-type .input-group-append .input-group-text {
  border-top-right-radius: 0.25rem !important;
  border-bottom-right-radius: 0.25rem !important;
}

.input-group-prepend,
.input-group-append {
  display: flex !important;
  align-items: center !important;
  height: 100% !important;
}

/* Ensure form control has consistent height */
.form-control {
  height: 38px !important;
  line-height: 1.5 !important;
}

/* Prevent input group height changes */
.input-group .form-control {
  height: 38px !important;
  min-height: 38px !important;
  max-height: 38px !important;
  overflow: hidden !important;
}

/* Specific fix for confirm password input group */
#new_confirm_password {
  height: 38px !important;
  min-height: 38px !important;
  max-height: 38px !important;
  line-height: 1.5 !important;
  vertical-align: top !important;
}

.input-group-text {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

/* Specific fix for confirm password eye icon alignment - More aggressive */
#confirm_eye_toggle {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 38px !important;
  min-height: 38px !important;
  max-height: 38px !important;
  position: absolute !important;
  top: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  width: 50px !important;
  z-index: 10 !important;
  border-top-right-radius: 0.25rem !important;
  border-bottom-right-radius: 0.25rem !important;
}

#confirm_eye_toggle a {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 100% !important;
  width: 100% !important;
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
}

#confirm_eye_toggle i {
  line-height: 1 !important;
  vertical-align: middle !important;
  margin: 0 !important;
  position: absolute !important;
  top: 50% !important;
  left: 50% !important;
  transform: translate(-50%, -50%) !important;
}

/* Same fix for new password eye icon */
#new_eye_toggle {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 38px !important;
  min-height: 38px !important;
  max-height: 38px !important;
  border-top-right-radius: 0.25rem !important;
  border-bottom-right-radius: 0.25rem !important;
}

#new_eye_toggle a {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 38px !important;
  width: 100% !important;
}

#new_eye_toggle i {
  line-height: 1 !important;
  vertical-align: middle !important;
  margin: 0 !important;
  position: relative !important;
  top: 0 !important;
  transform: none !important;
}

/* Ensure input fields work properly */
#new_password,
#new_confirm_password {
  pointer-events: auto !important;
  background: white !important;
  color: #333 !important;
}

/* Hover effects for eye icons */
#new_eye_toggle:hover,
#confirm_eye_toggle:hover {
  background: linear-gradient(135deg, #A0522D 0%, #8B4513 100%) !important;
  transition: all 0.3s ease !important;
}
</style>

<!-- Modal -->
<div class="modal fade" id="recoverModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 450px;">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);">
      
      <form id="recoverPasswordForm" method="post">
      <div class="modal-body" style="padding: 30px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container-fluid">
          <?php 
          
          
          if($count > 0){
            // Use the contact_number we determined based on civil status
            $contact_number = $contact_number_to_use;
     
            if(strlen((string)$contact_number) == 11){
              $myNumber = $contact_number[0] . $contact_number[1] . $contact_number[2] . $contact_number[3] . $contact_number[4] . $contact_number[5] . $contact_number[6] .'XXXX';

            }else{
              $myNumber = $contact_number[0] . $contact_number[1] . $contact_number[2] . $contact_number[3] . $contact_number[4] . $contact_number[5] . 'XXXX';
            }
         
          
            ?>

          <!-- Header Section -->
          <div class="text-center mb-4">
            <div class="mb-3">
              <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: #8B4513; background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
            </div>
            <h3 class="mb-2" style="color: #2d3748; font-weight: 700; font-size: 1.4rem;">YOUR NUMBER - <?= $myNumber ?></h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Please verify your identity to change your password</p>
          </div>

          <div class="row">
            <input type="hidden" name="check_username" id="check_username" value="<?= $username?>">
            <input type="hidden" name="check_number" id="check_number" value="<?= $contact_number_to_use;?>">
            
            <!-- Phone Number Verification -->
            <div class="col-sm-12 mb-4">
              <div class="form-group">
                <label class="form-label" style="color: #4a5568; font-weight: 600; margin-bottom: 8px;">Last 4 Digits of Your Number</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: 2px solid #8B4513; color: white; border-radius: 10px 0 0 10px; padding: 10px 14px;">
                      <i class="fas fa-mobile-alt"></i>
                    </span>
                  </div>
                  <input type="text" name="contact_number" maxlength="4" id="contact_number" class="form-control" placeholder="CORRECT LAST 4 DIGIT NUMBER" style="border: 2px solid #e2e8f0; border-left: none; border-radius: 0 10px 10px 0; padding: 10px 14px; font-size: 14px; transition: all 0.3s ease;">
                </div>
              </div>
            </div>

            <!-- New Password -->
            <div class="col-sm-12 mb-4">
              <div class="form-group">
                <label class="form-label" style="color: #4a5568; font-weight: 600; margin-bottom: 8px;">New Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: 2px solid #8B4513; color: white; border-radius: 10px 0 0 10px; padding: 10px 14px;">
                      <i class="fas fa-key"></i>
                    </span>
                  </div>
                  <input type="password" id="new_password" name="new_password" class="form-control" placeholder="NEW PASSWORD" style="border: 2px solid #e2e8f0; border-left: none; border-radius: 0; padding: 10px 14px; font-size: 14px; transition: all 0.3s ease;">
                  <div class="input-group-append">
                    <span class="input-group-text" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: 2px solid #8B4513; color: white; border-radius: 0 10px 10px 0; cursor: pointer; padding: 10px 14px;" id="new_eye_toggle">
                      <a href="#" style="color: white; text-decoration: none;"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Confirm Password -->
            <div class="col-sm-12 mb-4">
              <div class="form-group">
                <label class="form-label" style="color: #4a5568; font-weight: 600; margin-bottom: 8px;">Confirm Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: 2px solid #8B4513; color: white; border-radius: 10px 0 0 10px; padding: 10px 14px;">
                      <i class="fas fa-key"></i>
                    </span>
                  </div>
                  <input type="password" id="new_confirm_password" name="new_confirm_password" class="form-control" placeholder="CONFIRM PASSWORD" style="border: 2px solid #e2e8f0; border-left: none; border-radius: 0; padding: 10px 14px; font-size: 14px; transition: all 0.3s ease;">
                  <div class="input-group-append">
                    <span class="input-group-text" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: 2px solid #8B4513; color: white; border-radius: 0 10px 10px 0; cursor: pointer; padding: 10px 14px;" id="confirm_eye_toggle">
                      <a href="#" style="color: white; text-decoration: none;"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

            <?php
          }else{
           echo  '<div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <h5 class="text-danger font-weight-bold">WRONG USERNAME OR RESIDENT NUMBER</h5>
                    <p class="text-muted">Please check your input and try again.</p>
                  </div>';
           
          }
          
          
          
          ?>
         
        </div>
      </div>
      <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; padding: 20px 30px; border-top: 1px solid #e2e8f0;">
        <button type="button" class="btn btn-secondary btn-flat elevation-2 px-4" data-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
          <i class="fas fa-times mr-2"></i> CLOSE
        </button>
        <?php      
          if($count > 0){
            echo '<button type="submit" class="btn btn-primary btn-flat elevation-2 px-4" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);">
                    <i class="fas fa-save mr-2"></i> SAVE
                  </button>';
          }
          ?>
        
      </div>
      </form>


    </div>
  </div>
</div>


<style>
/* Enhanced Modal Styles */
.modal-content {
  animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: translateY(-50px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* Input Focus Effects */
.form-control:focus {
  border-color: #8B4513 !important;
  box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1) !important;
  outline: none !important;
}

/* Button Hover Effects */
.btn:hover {
  transform: translateY(-2px);
  transition: all 0.3s ease;
}

/* Input Group Hover Effects */
.input-group:hover .input-group-text {
  background: linear-gradient(135deg, #A0522D 0%, #8B4513 100%) !important;
  transition: all 0.3s ease;
}

/* Error State Styling */
.is-invalid {
  border-color: #dc3545 !important;
  box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  display: block;
}

/* Success State Styling */
.is-valid {
  border-color: #28a745 !important;
  box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1) !important;
}

/* Loading State */
.btn.loading {
  position: relative;
  color: transparent !important;
}

.btn.loading::after {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  top: 50%;
  left: 50%;
  margin-left: -8px;
  margin-top: -8px;
  border: 2px solid transparent;
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: button-loading-spinner 1s ease infinite;
}

@keyframes button-loading-spinner {
  from {
    transform: rotate(0turn);
  }
  to {
    transform: rotate(1turn);
  }
}
</style>

<script>


$(document).ready(function(){




      $(function () {
        $.validator.setDefaults({
          submitHandler: function (form) {
            console.log('Form submit handler called');
            
            // Check if passwords match before proceeding
            var password = $('#new_password').val();
            var confirmPassword = $('#new_confirm_password').val();
            
            console.log('Password:', password);
            console.log('Confirm Password:', confirmPassword);
            
            if (password !== confirmPassword) {
                console.log('Passwords do not match, preventing submission');
                $('#new_confirm_password').addClass('is-invalid');
                $('.password-error').remove();
                $('#new_confirm_password').after('<div class="password-error invalid-feedback">Passwords do not match</div>');
                return false;
            }
            
            console.log('Form validation passed, checking form data...');
            var formData = $(form).serialize();
            console.log('Form data before confirmation:', formData);
            
            Swal.fire({
              title: '<strong class="text-warning">Are you sure?</strong>',
              html: "<b>You want save this password?</b>",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, save it!',
              allowOutsideClick: false,
              width: '400px',
            }).then((result) => {
              if (result.value) {
                
                var formData = $(form).serialize();
                
                // Manual form data collection as fallback
                var manualFormData = {
                  check_username: $('#check_username').val(),
                  check_number: $('#check_number').val(),
                  contact_number: $('#contact_number').val(),
                  new_password: $('#new_password').val(),
                  new_confirm_password: $('#new_confirm_password').val()
                };
                
                console.log('Form data being sent:', formData);
                console.log('Manual form data:', manualFormData);
                console.log('Form elements:', $(form).find('input').map(function() {
                  return this.name + '=' + this.value;
                }).get());
                
                // Add loading state to submit button
                const submitBtn = $('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.addClass('loading').prop('disabled', true);
                
                // Disable form inputs during submission
                $('#recoverPasswordForm input').prop('disabled', true);
                
                $.ajax({
                    url: 'recorverNewPassword.php',
                    type: 'POST',
                    data: formData || manualFormData,
                    cache: false,
                    success:function(data){
                        // Trim whitespace from response
                        data = data.trim();
                        console.log('Server response:', data);
                        console.log('Response type:', typeof data);
                        console.log('Response length:', data.length);
    
                        if(data == 'error'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>4 DIGIT NOT MATCH</b><br><small>Please check the last 4 digits of your phone number</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error1'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>PASSWORD NOT MATCH</b><br><small>Please make sure both passwords are identical</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error2'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>PASSWORD TOO SHORT</b><br><small>Password must be at least 8 characters long</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error3'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>PASSWORD HASHING FAILED</b><br><small>Please try again</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error4'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>DATABASE UPDATE FAILED</b><br><small>Please try again</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error5'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>USER NOT FOUND</b><br><small>Username does not exist</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error6'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>MISSING REQUIRED FIELDS</b><br><small>Please fill in all required fields</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'error7'){
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>EMPTY REQUIRED FIELDS</b><br><small>Please fill in all required fields</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }else if(data == 'success'){

                          Swal.fire({
                            title: '<strong class="text-success">SUCCESS</strong>',
                            type: 'success',
                            html: '<b>Password Updated Successfully!</b><br><small>You will be redirected to login page</small>',
                            width: '400px',
                            confirmButtonColor: '#8B4513',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                          }).then(()=>{
                            window.location.href="login.php";
                          })

                        }else{
                          Swal.fire({
                              title: '<strong class="text-danger">ERROR</strong>',
                              type: 'error',
                              html: '<b>UNKNOWN ERROR</b><br><small>Response: ' + data + '</small><br><small>Please try again</small>',
                              width: '400px',
                              confirmButtonColor: '#8B4513',
                              confirmButtonText: 'Try Again'
                            })
                        }

                        // Remove loading state
                        submitBtn.removeClass('loading').prop('disabled', false).html(originalText);
                        $('#recoverPasswordForm input').prop('disabled', false);
                       
                    }    
                }).fail(function(){
                    Swal.fire({
                      title: '<strong class="text-danger">Oops..</strong>',
                      type: 'error',
                      html: '<b>Something went wrong!</b><br><small>Please check your connection and try again</small>',
                      width: '400px',
                      confirmButtonColor: '#8B4513',
                      confirmButtonText: 'Try Again'
                    })
                    
                    // Remove loading state
                    submitBtn.removeClass('loading').prop('disabled', false).html(originalText);
                    $('#recoverPasswordForm input').prop('disabled', false);
                })

              }
            })
            
          }
        });
      $('#recoverPasswordForm').validate({
        rules: {
         
          new_password: {
            required: true,
           minlength: 8
          },
          contact_number: {
            required: true,
           minlength: 4,
           maxlength: 4
          },
          new_confirm_password: {
            required: true,
           minlength: 8,
           equalTo: "#new_password"
          },
        
        },
        messages: {
         
          new_password: {
            required: "Please enter your new password",
            minlength: "Password must be at least 8 characters long"
           
          },

          new_confirm_password: {
            required: "Please confirm your new password",
            minlength: "Password must be at least 8 characters long",
            equalTo: "Passwords do not match"
          },
          
          contact_number: {
            required: "Please enter the last 4 digits of your phone number",
            minlength: "Please enter exactly 4 digits",
            maxlength: "Please enter exactly 4 digits"
          },
        
        },
      
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
      });
    })








  $("#new_eye_toggle a").on('click', function(event) {
        event.preventDefault();
        if($('#new_password').attr("type") == "text"){
            $('#new_password').attr('type', 'password');
            $('#new_eye_toggle i').addClass( "fa-eye-slash" );
            $('#new_eye_toggle i').removeClass( "fa-eye" );
        }else if($('#new_password').attr("type") == "password"){
            $('#new_password').attr('type', 'text');
            $('#new_eye_toggle i').removeClass( "fa-eye-slash" );
            $('#new_eye_toggle i').addClass( "fa-eye" );
        }
    });
    $("#confirm_eye_toggle a").on('click', function(event) {
        event.preventDefault();
        if($('#new_confirm_password').attr("type") == "text"){
            $('#new_confirm_password').attr('type', 'password');
            $('#confirm_eye_toggle i').addClass( "fa-eye-slash" );
            $('#confirm_eye_toggle i').removeClass( "fa-eye" );
        }else if($('#new_confirm_password').attr("type") == "password"){
            $('#new_confirm_password').attr('type', 'text');
            $('#confirm_eye_toggle i').removeClass( "fa-eye-slash" );
            $('#confirm_eye_toggle i').addClass( "fa-eye" );
        }
    });

    // Ensure input fields are enabled
    $('#new_password, #new_confirm_password').prop('disabled', false).removeAttr('readonly');
    
    // Fix eye icon alignment when typing in confirm password - More aggressive
    $('#new_confirm_password').on('input focus keyup keydown paste', function() {
        $('#confirm_eye_toggle').css({
            'position': 'absolute',
            'top': '0px',
            'right': '0px',
            'bottom': '0px',
            'height': '38px',
            'transform': 'none'
        });
        $('#confirm_eye_toggle i').css({
            'position': 'absolute',
            'top': '50%',
            'left': '50%',
            'transform': 'translate(-50%, -50%)'
        });
    });
    
    // Also fix on page load and when modal opens
    $(document).ready(function() {
        setTimeout(function() {
            $('#confirm_eye_toggle').css({
                'position': 'absolute',
                'top': '0px',
                'right': '0px',
                'bottom': '0px',
                'height': '38px'
            });
        }, 100);
    });
    
    // Real-time password validation
    $('#new_password, #new_confirm_password').on('input', function() {
        var password = $('#new_password').val();
        var confirmPassword = $('#new_confirm_password').val();
        
        // Remove existing error messages
        $('.password-error').remove();
        $('#new_confirm_password').removeClass('is-invalid');
        
        if (confirmPassword !== '' && password !== confirmPassword) {
            $('#new_confirm_password').addClass('is-invalid');
            $('#new_confirm_password').after('<div class="password-error invalid-feedback">Passwords do not match</div>');
        } else if (confirmPassword !== '' && password === confirmPassword) {
            $('#new_confirm_password').removeClass('is-invalid').addClass('is-valid');
        }
    });


})



  
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

 
  $("#contact_number").inputFilter(function(value) {
  return /^-?\d*$/.test(value); 
  
  });



</script>