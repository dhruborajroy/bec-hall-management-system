<?php
session_start();
session_regenerate_id();
include('../inc/function.inc.php');
include('../inc/connection.inc.php');
include('../inc/constant.inc.php');
require_once("../inc/smtp/class.phpmailer.php");
$type=get_safe_value($_POST['type']);
if($type=='otp'){
    $email=get_safe_value($_POST['email']);
    if(mysqli_num_rows(mysqli_query($con,"select id from users where email='$email'"))>0){
        $otp=rand(1111,9999);
        $_SESSION['OTP']=$otp;
        $_SESSION['EMAIL']=$email;
        echo send_email($email,'Your otp is '. $otp,'Otp email');
    }else{
        echo "not_registered";
    }
}