<?php
session_start();
session_regenerate_id();
include('../inc/function.inc.php');
include('../inc/connection.inc.php');
include('../inc/constant.inc.php');
require_once("../inc/smtp/class.phpmailer.php");
$type=get_safe_value($_POST['type']);
// sendLoginEmail($row['email']);
//sendLoginEmail("orinkarmaker03@gmail.com");
if($type=='otp'){
    $email=get_safe_value($_POST['email']);
    //sendLoginEmail("orinkarmaker03@gmail.com");
    // send_email_using_tamplate();
    // echo $email;
    $otp=rand(1111,9999);
    $_SESSION['OTP']=$otp;
    echo send_email($email,'Your otp is '. $otp,'Otp email');
}