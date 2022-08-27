<?php 
session_start();
session_regenerate_id();
include('../webadmin/inc/function.inc.php');
include('../webadmin/inc/connection.inc.php');
include('../webadmin/inc/constant.inc.php');
require_once("../webadmin/inc/smtp/class.phpmailer.php");
$msg="";
if(!isset($_SESSION['FORGOT_PASSWORD'])){
    redirect('index.php');
}
$email=$_SESSION['EMAIL'];
if(isset($_POST['submit'])){
	$password=get_safe_value($_POST['password']);
    $password=password_hash($password,PASSWORD_DEFAULT);
   	$sql="update `users` set `password`='$password' where `email`='$email'";
	$res=mysqli_query($con,$sql);
    $_SESSION['UPDATE']=true;
    send_email($email,"Password Updated","Password Changed");
    unset($_SESSION['FORGOT_PASSWORD']);
    redirect("index.php");
}
?>

<!doctype html>
<html class="no-js" lang="">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BEC Hall Management System | Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="../webadmin/css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../webadmin/css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../webadmin/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../webadmin/css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="../webadmin/css/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../webadmin/css/style.css">
    <!-- Modernize js -->
    <script src="../webadmin/js/modernizr-3.6.0.min.js"></script>
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
                    <img src="img/logo2.png" alt="logo">
                </div>
                <form id="validate" class="login-form" method="POST">
                    <div class="form-group">
                        <?php echo $msg?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" placeholder="Enter password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="text" placeholder="Enter password again" class="form-control" name="cpassword" id="cpassword">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="login-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Login Page End Here -->
    <!-- jquery-->
    <script src="../webadmin/js/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="../webadmin/js/plugins.js"></script>
    <!-- Popper js -->
    <script src="../webadmin/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../webadmin/js/bootstrap.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="../webadmin/js/jquery.scrollUp.min.js"></script>
    <!-- Custom Js -->
    <script src="../webadmin/js/main.js"></script>
    <!-- validate JS -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- validate  -->
    <script src="../webadmin/js/validation.php"></script>

</body>

</html>