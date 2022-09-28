<?php
// require_once("./smtp/class.phpmailer.php");
include('function.inc.php');
include('constant.inc.php');

// send_email("dhruborajroy3@gmail.com",'Your account has been created. ','Account Created');
echo "<pre>";
$grandToken=grandToken();
$user_data=['tran_id'=>'ssdn','amount'=>1];
$createPayment=createPayment($grandToken['id_token'],$user_data);
print_r($createPayment);
?>