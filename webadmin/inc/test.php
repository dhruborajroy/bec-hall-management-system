<?php
include("./constant.inc.php");
include("./connection.inc.php");
include("./function.inc.php");
require_once("./smtp/class.phpmailer.php");
// send_email("Dhruborajroy3@gmail.com",send_email_using_tamplate("Dhrubo","1122","2"),"Subject"); 
// echo "<pre>";
// print_r($_GET);
echo password_hash("Dhrubo",PASSWORD_DEFAULT);
// $dpassword='$2y$10$R6VvvGp/0j7mIpZgdZqSXuFx8dzcd.vaTs2Zll7KiDEmsvjxOV0XO';
echo password_verify("Ddhrubo",$dpassword);