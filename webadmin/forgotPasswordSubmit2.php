<?php 
session_start();
session_regenerate_id();
include('./inc/function.inc.php');
include('./inc/connection.inc.php');
include('./inc/constant.inc.php');
require_once("./inc/smtp/class.phpmailer.php");
$msg="";
// if(!isset($_SESSION['FORGOT_PASSWORD'])){
//     redirect('index.php');
// }
$email=$_SESSION['EMAIL'];
if(isset($_POST['submit'])){
	$password=get_safe_value($_POST['password']);
   	$sql="update users set password='$password' where email='$email'";
	$res=mysqli_query($con,$sql);
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
    <link rel="stylesheet" href="./css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="./css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="./css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="./css/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Modernize js -->
    <script src="./js/modernizr-3.6.0.min.js"></script>
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
                <form class="login-form" method="POST">
                    <div class="form-group">
                        <?php echo $msg?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" placeholder="Enter password" class="form-control" name="password" id="password">
                        <!-- <i class="far fa-envelope"></i> -->
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="text" placeholder="Enter password again" class="form-control" name="phoneNumber"  id="cpassword">
                        <!-- <i class="far fa-envelope"></i> -->
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
    <script src="./js/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="./js/plugins.js"></script>
    <!-- Popper js -->
    <script src="./js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="./js/bootstrap.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="./js/jquery.scrollUp.min.js"></script>
    <!-- Custom Js -->
    <script src="./js/main.js"></script>

</body>

</html>