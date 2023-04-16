<?php
session_start();
session_regenerate_id();
include('./inc/function.inc.php');
include('./inc/connection.inc.php');
include('./inc/constant.inc.php');
require_once("./inc/smtp/class.phpmailer.php");
$msg=""; 
$class="";
if(isset($_SESSION['APPLICANT_LOGIN'])){
    redirect('dashboard');
}
if(isset($_POST['submit'])){
	$email=get_safe_value($_POST['email']);
   $password=get_safe_value($_POST['password']);
   $sql="select * from applicants where email='$email'";
	$res=mysqli_query($con,$sql);
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		if($row['status']!=1){
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'warning',
            'body'=>'You haven\'t verified your email yet. Please verify the email',
            'title'=>'Email Error',
         );
         $class='class="alert alert-danger"'; 
			// $msg="You haven't verified your email yet. Please verify the email";
		}else{
            $verify=password_verify($password,$row['password']);
            if($verify==1){
               $msg="You are aleady registered. Please login";
               $_SESSION['APPLICANT_LOGIN']="1";
               $_SESSION['APPLICANT_ID']=$row['id'];
               $_SESSION['APPLICANT_NAME']=$row['first_name']." ".$row['last_name'];
               // sendLoginEmail($row['email']);
               redirect('dashboard');
               die();
            }else{
               $_SESSION['TOASTR_MSG']=array(
                  'type'=>'error',
                  'body'=>'Please Enter correct Login details',
                  'title'=>'Error',
               );
         
               // $class='class="alert alert-danger" style="padding:10px;margin:100px"';  
		         // $msg="Please Enter correct Login details";
            }
		}
      // echo $sql;
	}else{
      $class='class="alert alert-danger" style="padding:10px;margin:100px"';  
		$msg="Please Enter correct Login details";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <title><?php echo NAME." || ".TAGLINE?></title>
      <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
      <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
      <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="assets/plugins/feather/feather.css">
      <link rel="stylesheet" href="assets/css/toastr.min.css">
      <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body>
      <div class="main-wrapper log-wrap">
         <div class="row">
            <div class="col-md-6 login-bg">
               <div class="owl-carousel login-slide owl-theme">
                  <div class="welcome-login">
                     <div class="login-banner">
                        <img src="assets/img/login-img.png" class="img-fluid" alt="Logo">
                     </div>
                     <div class="mentor-course text-center">
                        <h2>Welcome to <br>DreamsLMS Courses.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                     </div>
                  </div>
                  <div class="welcome-login">
                     <div class="login-banner">
                        <img src="assets/img/login-img.png" class="img-fluid" alt="Logo">
                     </div>
                     <div class="mentor-course text-center">
                        <h2>Welcome to <br>DreamsLMS Courses.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                     </div>
                  </div>
                  <div class="welcome-login">
                     <div class="login-banner">
                        <img src="assets/img/login-img.png" class="img-fluid" alt="Logo">
                     </div>
                     <div class="mentor-course text-center">
                        <h2>Welcome to <br>DreamsLMS Courses.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 login-wrap-bg">
               <div class="login-wrapper">
                  <div class="loginbox">
                     <div class="w-100">
                        <div class="img-logo">
                           <img src="assets/img/logo.svg" class="img-fluid" alt="Logo">
                           <div class="back-home">
                              <a href="index">Back to Home</a>
                           </div>
                        </div>
                        <h1>Sign into Your Account</h1>
                        <span <?php echo $class?> ><?php echo $msg?></span>
                        <form method="post">
                           <div class="form-group">
                              <label class="form-control-label">Email</label>
                              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                           </div>
                           <div class="form-group">
                              <label class="form-control-label">Password</label>
                              <div class="pass-group">
                                 <input type="password" name="password" id="password" class="form-control pass-input" placeholder="Enter your password">
                                 <span class="feather-eye toggle-password"></span>
                              </div>
                           </div>
                           <div class="forgot">
                              <span><a class="forgot-link" href="forgot-password.html">Forgot Password ?</a></span>
                           </div>
                           <div class="remember-me">
                              <label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Remember me
                              <input type="checkbox" name="radio">
                              <span class="checkmark"></span>
                              </label>
                           </div>
                           <div class="d-grid">
                              <button class="btn btn-primary btn-start"  name="submit" type="submit">Sign In</button>
                           </div>
                        </form>
                        <div class="google-bg text-center">
                           <p class="mb-0">New User ? <a href="apply">Apply Online</a></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/jquery-3.6.0.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
      <script src="assets/js/toastr.min.js"></script>
      <script src="assets/js/script.js"></script>
      <script>
         //info
         //warning
         //success
         //error
         function toastrMsg(msgType,title,body){
            toastr.options = {
               "closeButton": true,
               "debug": false,
               "newestOnTop": true,
               "progressBar": true,
               "positionClass": "toast-top-right",
               "preventDuplicates": false,
               "onclick": null,
               "showDuration": "30",
               "hideDuration": "1000",
               "timeOut": "30000",
               "extendedTimeOut": "1000",
               "showEasing": "swing",
               "hideEasing": "linear",
               "showMethod": "fadeIn",
               "hideMethod": "fadeOut"
            }
            toastr[msgType](body, title);
         }
      </script>
   </body>
</html>

<?php 
if(isset($_SESSION['TOASTR_MSG'])){?>
   <script>
      toastrMsg('<?php echo $_SESSION['TOASTR_MSG']['type']?>',"<?php echo $_SESSION['TOASTR_MSG']['body']?>","<?php echo $_SESSION['TOASTR_MSG']['title']?>");
   </script>
<?php 
unset($_SESSION['TOASTR_MSG']);
}
?>