<?php
session_start();
session_regenerate_id();
include('../inc/function.inc.php');
include('../inc/connection.inc.php');
include('../inc/constant.inc.php');
if(isset($_POST['otp'])){
    $otp=get_safe_value($_POST['otp']);
    if($_SESSION['OTP']==$otp){
        echo "done";
        $_SESSION['FORGOT_PASSWORD']=true;
    }else{
        echo "error";
    }
    // $otp=rand(1111,9999);
}