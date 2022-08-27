<?php
include("./constant.inc.php");
include("./connection.inc.php");
include("./function.inc.php");
require_once("./smtp/class.phpmailer.php");
$salt="dsckndkn";
$hash=password_hash($salt."123Dhrubo",PASSWORD_DEFAULT);

echo password_verify($salt."123Dhrubo",$hash);