<?php 
session_start();
session_regenerate_id();
include('../inc/function.inc.php');
include('../inc/connection.inc.php');
include('../inc/constant.inc.php');
require_once("../inc/smtp/class.phpmailer.php");
$msg="";
if(isset($_SESSION['ADMIN_LOGIN'])){
    redirect('index.php');
}
if(isset($_POST['submit'])){
	$email=get_safe_value($_POST['email']);
   	$password=get_safe_value($_POST['password']);
   	$sql="select * from admin where email='$email'";
	$res=mysqli_query($con,$sql);
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		if($row['status']!=1){
			$msg="You haven't verified your email yet. Please verify the email";
		}else{
            $verify=password_verify($password,$row['password']);
            if($verify==1){
                $msg="You are aleady registered. Please login";
                $_SESSION['ADMIN_LOGIN']=true;
                $_SESSION['ADMIN_ID']=$row['id'];
                $_SESSION['ADMIN_NAME']=$row['name'];
                // sendLoginEmail($row['email']);
                // sendLoginEmail("orinkarmaker03@gmail.com");
                redirect('./index.php');
                die();
            }else{
		        $msg="Please Enter correct Login details";
            }
		}		
	}else{
		$msg="Please Enter correct Login details";
	}
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Get Admitted Online | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Modernize js -->
    <script src="js/modernizr-3.6.0.min.js"></script>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Login Page Start Here -->
    <div class="login-page-wrap">
        <div class="login-page-content">
            <div class="login-box">
                <div class="item-logo">
                    <img src="<?php echo FRONT_SITE_PATH?>/webadmin/img/logo2.png" alt="logo">
                </div>
                <form class="login-form" method="POST" id="validate">
                    <div class="form-group">
                        <?php echo $msg?>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" placeholder="Enter usrename" class="form-control" name="email">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="Enter password" class="form-control" name="password">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember-me" >
                            <label for="remember-me" class="form-check-label">Remember Me</label>
                        </div>
                        <a href="forgotPassword.php" class="forgot-btn">Forgot Password?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="login-btn">Login</button>
                    </div>
                </form>
                <div class="">Don't have an account ? <a href="#">Signup now!</a></div>
            </div>
        </div>
    </div>
    <!-- Login Page End Here -->
    <!-- jquery-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
<!-- validate JS -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- Custom Js -->
    <script src="js/main.js"></script>
    <script src="js/validation.php"></script>

</body>

</html>