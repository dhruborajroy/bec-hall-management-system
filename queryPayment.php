<?php 
session_start();
session_regenerate_id();
require("./inc/connection.inc.php");
require("./inc/constant.inc.php");
require("./inc/function.inc.php");
require_once("./inc/smtp/class.phpmailer.php");
$token=timeWiseTokenGeneartion();
$searchTransection=searchTransection("9IO807V2R6",$token['id_token']);
prx($searchTransection);
$queryPayment=queryPayment("TR0011GQ1664018359795",$token['id_token']);
pr($queryPayment);

?>